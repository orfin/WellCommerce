<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Component\Search\Adapter\ZendLucene;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Search\Adapter\AdapterInterface;
use WellCommerce\Component\Search\Adapter\QueryBuilderInterface;
use WellCommerce\Component\Search\Model\DocumentInterface;
use WellCommerce\Component\Search\Model\FieldInterface;
use WellCommerce\Component\Search\Request\SearchRequestInterface;
use ZendSearch\Lucene\Analysis\Analyzer\Analyzer;
use ZendSearch\Lucene\Analysis\Analyzer\Common\Utf8\CaseInsensitive;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Lucene;
use ZendSearch\Lucene\Search\QueryParser;
use ZendSearch\Lucene\SearchIndexInterface;
use ZendSearch\Lucene\Storage\Directory\Filesystem as LuceneFilesystem;

/**
 * Class ZendLuceneAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ZendLuceneAdapter implements AdapterInterface
{
    /**
     * @var array
     */
    private $options = [];
    
    /**
     * ElasticSearchAdapter constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }
    
    public function search(SearchRequestInterface $request) : array
    {
        $index   = $this->getIndex($request->getLocale());
        $query   = $this->createQueryBuilder($request)->getQuery();
        $results = $index->find($query);
        
        return $this->processResults($results);
    }
    
    public function createIndex(string $locale)
    {
        $path  = $this->getIndexPath($locale);
        $index = Lucene::create($path);
        
        return $index;
    }
    
    public function removeIndex(string $locale)
    {
        $path       = $this->getIndexPath($locale);
        $filesystem = new Filesystem();
        if ($filesystem->exists($path)) {
            $filesystem->remove($path);
        }
    }
    
    public function flushIndex(string $locale)
    {
        $this->removeIndex($locale);
        $this->createIndex($locale);
    }
    
    public function optimizeIndex(string $locale)
    {
        $this->getIndex($locale)->optimize();
    }
    
    public function addDocument(DocumentInterface $document)
    {
        $index          = $this->getIndex($document->getLocale());
        $luceneDocument = new Document();
        $luceneDocument->addField(Document\Field::unIndexed('identifier', $document->getIdentifier()));
        $luceneDocument->addField(Document\Field::keyword('type', $document->getType()->getName()));

        $document->getFields()->map(function (FieldInterface $field) use ($luceneDocument) {
            $documentField        = Document\Field::text($field->getName(), $field->getValue());
            $documentField->boost = $field->getBoost();
            $luceneDocument->addField($documentField);
        });

        $index->addDocument($luceneDocument);
        $index->commit();
    }
    
    public function updateDocument(DocumentInterface $document)
    {
        $this->removeDocument($document);
        $this->addDocument($document);
    }
    
    public function removeDocument(DocumentInterface $document)
    {
        $index = $this->getIndex($document->getLocale());
        $index->delete($document->getIdentifier());
    }
    
    private function getIndex(string $locale) : SearchIndexInterface
    {
        $path = $this->getIndexPath($locale);
        if (false === $this->hasIndex($path)) {
            $index = $this->createIndex($locale);
        } else {
            $index = Lucene::open($path);
        }
        
        Analyzer::setDefault(new CaseInsensitive);
        LuceneFilesystem::setDefaultFilePermissions(0775);
        QueryParser::setDefaultEncoding('UTF-8');
        $index->setMaxBufferedDocs($this->options['max_buffered_docs']);
        $index->setMaxMergeDocs($this->options['max_merge_docs']);
        $index->setMergeFactor($this->options['merge_factor']);
        
        return $index;
    }
    
    public function hasIndex(string $path) : bool
    {
        $filesystem = new Filesystem();
        
        return $filesystem->exists($path);
    }
    
    private function getIndexPath(string $locale) : string
    {
        return sprintf('%s/%s%s', rtrim($this->options['index_path'], '/'), $this->options['index_prefix'], $locale);
    }

    private function createQueryBuilder(SearchRequestInterface $request) : QueryBuilderInterface
    {
        return new $this->options['query_builder_class']($request, $this->options['query_min_length']);
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'index_prefix',
            'index_path',
            'query_min_length',
            'result_limit',
            'max_buffered_docs',
            'max_merge_docs',
            'merge_factor',
            'query_builder_class'
        ]);
        
        $resolver->setDefault('index_prefix', 'wellcommerce_');
        $resolver->setDefault('query_min_length', 3);
        $resolver->setDefault('result_limit', 100);
        $resolver->setDefault('max_buffered_docs', 1000);
        $resolver->setDefault('max_merge_docs', 10000);
        $resolver->setDefault('merge_factor', 10);
        $resolver->setDefault('number_of_replicas', 0);
        $resolver->setDefault('query_builder_class', ZendLuceneQueryBuilder::class);
        
        $resolver->setAllowedTypes('index_prefix', 'string');
        $resolver->setAllowedTypes('index_path', 'string');
        $resolver->setAllowedTypes('query_min_length', 'integer');
        $resolver->setAllowedTypes('result_limit', 'integer');
        $resolver->setAllowedTypes('max_buffered_docs', 'integer');
        $resolver->setAllowedTypes('max_merge_docs', 'integer');
        $resolver->setAllowedTypes('merge_factor', 'integer');
        $resolver->setAllowedTypes('query_builder_class', 'string');
    }

    private function processResults(array $results) : array
    {
        $hits = [];

        foreach ($results as $result) {
            if ($result->score >= .1) {
                $hits[] = $result->identifier;
            }
        }

        return $hits;
    }
}
