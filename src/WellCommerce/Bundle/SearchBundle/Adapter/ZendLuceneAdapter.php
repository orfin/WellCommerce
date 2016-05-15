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

namespace WellCommerce\Bundle\SearchBundle\Adapter;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\SearchBundle\Query\SearchQuery;
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
final class ZendLuceneAdapter implements SearchAdapterInterface
{
    /**
     * @var array
     */
    protected $options = [];
    
    /**
     * ZendLuceneAdapter constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    public function search(SearchQuery $query) : array
    {
        $index       = $this->getIndex();
        $identifiers = [];
        $results     = $index->find($query->getSearchPhrase() . '~');
        foreach ($results as $result) {
            if ($result->score >= .1) {
                $identifiers[] = $result->identifier;
            }
        }

        return $identifiers;
    }

    public function add($document)
    {
        $index = $this->getIndex();
        $index->addDocument($document);
        $index->commit();
        $index->optimize();
    }

    public function remove(int $identifier)
    {
        $index = $this->getIndex();
        $index->delete($identifier);
    }

    public function update(int $identifier, $document)
    {
        $this->remove($identifier);
        $this->add($document);
    }

    public function optimize()
    {
        $this->getIndex()->optimize();
    }

    public function purge()
    {
        $path       = $this->getIndexPath();
        $filesystem = new Filesystem();
        if ($filesystem->exists($path)) {
            $filesystem->remove($path);
        }
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'index_file',
            'max_buffered_docs',
            'max_merge_docs',
            'merge_factor',
        ]);
        
        $resolver->setDefaults([
            'max_buffered_docs' => 10,
            'max_merge_docs'    => 1000,
            'merge_factor'      => 10,
        ]);
        
        $resolver->setAllowedTypes('index_file', 'string');
        $resolver->setAllowedTypes('max_buffered_docs', 'int');
        $resolver->setAllowedTypes('max_merge_docs', 'int');
        $resolver->setAllowedTypes('merge_factor', 'int');
    }

    private function getIndex() : SearchIndexInterface
    {
        $path = $this->getIndexPath();
        if (!$this->checkIndexPath($path)) {
            $index = Lucene::create($path);
        } else {
            $index = Lucene::open($path);
        }
        
        Analyzer::setDefault(new CaseInsensitive);
        LuceneFilesystem::setDefaultFilePermissions(0775);
        QueryParser::setDefaultEncoding('UTF-8');
        $index->setMaxBufferedDocs($this->options['max_buffered_docs']);
        $index->setMaxMergeDocs($this->options['max_merge_docs']);
        $index->setMergeFactor($this->options['merge_factor']);
        $index->optimize();
        
        return $index;
    }
    
    private function checkIndexPath(string $path) : bool
    {
        return file_exists($path) && is_readable($path) && ($resources = scandir($path)) && (count($resources) > 2);
    }

    private function getIndexPath() : string
    {
        return $this->options['index_file'];
    }
}
