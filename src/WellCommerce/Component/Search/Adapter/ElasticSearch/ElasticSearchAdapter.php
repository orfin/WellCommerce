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

namespace WellCommerce\Component\Search\Adapter\ElasticSearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Search\Adapter\AdapterInterface;
use WellCommerce\Component\Search\Adapter\QueryBuilderInterface;
use WellCommerce\Component\Search\Model\DocumentInterface;
use WellCommerce\Component\Search\Model\FieldInterface;
use WellCommerce\Component\Search\Request\SearchRequestInterface;

/**
 * Class ElasticSearchAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ElasticSearchAdapter implements AdapterInterface
{
    /**
     * @var array
     */
    private $options = [];
    
    /**
     * @var Client
     */
    private $client;

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
        $params = [
            'index' => $this->getIndexName($request->getLocale()),
            'type'  => $request->getType()->getName(),
            "size"  => $this->options['result_limit'],
            'body'  => [
                'query' => $this->createQueryBuilder($request)->getQuery()
            ]
        ];

        $results = $this->getClient()->search($params);

        return $this->processResults($results);
    }

    public function addDocument(DocumentInterface $document)
    {
        $params = [
            'index' => $this->getIndexName($document->getLocale()),
            'type'  => $document->getType()->getName(),
            'id'    => $document->getIdentifier(),
            'body'  => $this->createDocumentBody($document)
        ];
        
        $this->getClient()->index($params);
    }
    
    public function removeDocument(DocumentInterface $document)
    {
        $params = [
            'index' => $this->getIndexName($document->getLocale()),
            'type'  => $document->getType()->getName(),
            'id'    => $document->getIdentifier(),
        ];
        
        $this->getClient()->delete($params);
    }
    
    public function updateDocument(DocumentInterface $document)
    {
        $params = [
            'index' => $this->getIndexName($document->getLocale()),
            'type'  => $document->getType()->getName(),
            'id'    => $document->getIdentifier(),
            'body'  => $this->createDocumentBody($document)
        ];
        
        $this->getClient()->update($params);
    }

    public function getIndexName(string $locale) : string
    {
        return sprintf('%s%s', $this->options['index_prefix'], $locale);
    }

    public function createIndex(string $locale)
    {
        return $this->getClient()->indices()->create([
            'index' => $this->getIndexName($locale),
            'body'  => [
                'settings' => [
                    'number_of_shards'   => $this->options['number_of_shards'],
                    'number_of_replicas' => $this->options['number_of_replicas']
                ]
            ]
        ]);
    }

    public function removeIndex(string $locale)
    {
        if (false === $this->hasIndex($locale)) {
            return false;
        }

        return $this->getClient()->indices()->delete([
            'index' => $this->getIndexName($locale)
        ]);
    }
    
    public function flushIndex(string $locale)
    {
        if (false === $this->hasIndex($locale)) {
            return $this->createIndex($locale);
        }

        return $this->getClient()->indices()->flush([
            'index' => $this->getIndexName($locale)
        ]);

    }

    public function optimizeIndex(string $locale)
    {
        if (false === $this->hasIndex($locale)) {
            $this->createIndex($locale);
        }

        return $this->getClient()->indices()->optimize([
            'index' => $this->getIndexName($locale)
        ]);
    }
    
    public function getStats(string $locale)
    {
        if (false === $this->hasIndex($locale)) {
            $this->createIndex($locale);
        }

        return $this->getClient()->indices()->stats([
            'index' => $this->getIndexName($locale)
        ]);
    }

    private function createQueryBuilder(SearchRequestInterface $request) : QueryBuilderInterface
    {
        return new $this->options['query_builder_class']($request, $this->options['query_min_length']);
    }
    
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'index_prefix',
            'query_min_length',
            'result_limit',
            'number_of_shards',
            'number_of_replicas',
            'query_builder_class'
        ]);
        
        $resolver->setDefault('index_prefix', 'wellcommerce_');
        $resolver->setDefault('query_min_length', 3);
        $resolver->setDefault('result_limit', 100);
        $resolver->setDefault('number_of_shards', 2);
        $resolver->setDefault('number_of_replicas', 0);
        $resolver->setDefault('query_builder_class', ElasticSearchQueryBuilder::class);

        $resolver->setAllowedTypes('index_prefix', 'string');
        $resolver->setAllowedTypes('query_min_length', 'integer');
        $resolver->setAllowedTypes('result_limit', 'integer');
        $resolver->setAllowedTypes('number_of_shards', 'integer');
        $resolver->setAllowedTypes('number_of_replicas', 'integer');
        $resolver->setAllowedTypes('query_builder_class', 'string');
    }

    private function createDocumentBody(DocumentInterface $document) : array
    {
        $body = [];

        $document->getFields()->map(function (FieldInterface $field) use (&$body) {
            $body[$field->getName()] = $field->getValue();
        });

        return $body;
    }

    private function getClient() : Client
    {
        if (null === $this->client) {
            $this->client = ClientBuilder::create()->build();
        }

        return $this->client;
    }
    
    private function hasIndex(string $locale) : bool
    {
        return $this->getClient()->indices()->exists([
            'index' => $this->getIndexName($locale)
        ]);
    }

    private function processResults(array $results) : array
    {
        $identifiers = [];

        foreach ($results['hits']['hits'] as $hit) {
            $identifiers[] = $hit['_id'];
        }

        return $identifiers;
    }
}
