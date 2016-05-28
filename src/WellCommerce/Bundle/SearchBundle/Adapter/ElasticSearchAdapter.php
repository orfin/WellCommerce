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

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\SearchBundle\Document\DocumentFieldInterface;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Class ElasticSearchAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ElasticSearchAdapter implements AdapterInterface
{
    /**
     * @var string
     */
    private $indexName;

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
    
    public function search(IndexTypeInterface $indexType, Request $request, int $limit = 100) : array
    {
        $params = [
            'index' => $this->getIndexName($request->getLocale()),
            'type'  => $indexType->getName(),
            "size"  => $limit,
            'body'  => [
                'query' => [
                    'template' => [
                        'inline' => [
                            "query_string" => [
                                'phrase_slop'                  => 1,
                                'auto_generate_phrase_queries' => true,
                                'query'                        => '{{query_string}}',
                                'fields'                       => ["name_en^5", "description_*"],
                            ]
                        ],
                        'params' => [
                            'query_string' => 'perspiciatis',
                        ]
                    ],
                ]
            ]
        ];

        $results = $this->client->search($params);

        print_r($results);
        die();

        return $this->processResults($results);
    }

    public function addDocument(DocumentInterface $document)
    {
        $body = [];
        
        $document->getFields()->map(function (DocumentFieldInterface $field) use (&$body) {
            $body[$field->getName()] = $field->getValue();
        });
        
        $params = [
            'index' => $this->getIndexName($document->getLocale()),
            'type'  => $document->getIndexType()->getName(),
            'id'    => $document->getIdentifier(),
            'body'  => $body
        ];
        
        $this->client->index($params);
    }
    
    public function removeDocument(DocumentInterface $document)
    {
        $params = [
            'index' => $this->getIndex(),
            'type'  => $document->getType()->getName(),
            'id'    => $document->getIdentifier(),
        ];
        
        $this->client->delete($params);
    }
    
    public function updateDocument(DocumentInterface $document)
    {
        $body = [];
        
        $document->getFields()->map(function (DocumentFieldInterface $field) use (&$body) {
            $body[$field->getName()] = $field->getValue();
        });
        
        $params = [
            'index' => $this->getIndex(),
            'type'  => $document->getType()->getName(),
            'id'    => $document->getIdentifier(),
            'body'  => $body
        ];
        
        $this->client->update($params);
    }

    public function getIndexName(string $locale) : string
    {
        return sprintf('%s%s', $this->options['index_prefix'], $locale);
    }

    public function hasIndex(string $locale) : bool
    {
        return $this->getClient()->indices()->exists([
            'index' => $this->getIndexName($locale)
        ]);
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
    
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'index_prefix',
            'query_min_length',
            'number_of_shards',
            'number_of_replicas',
        ]);
        
        $resolver->setDefault('index_prefix', 'wellcommerce_');
        $resolver->setDefault('query_min_length', 3);
        $resolver->setDefault('number_of_shards', 2);
        $resolver->setDefault('number_of_replicas', 0);

        $resolver->setAllowedTypes('index_prefix', 'string');
        $resolver->setAllowedTypes('query_min_length', 'integer');
        $resolver->setAllowedTypes('number_of_shards', 'integer');
        $resolver->setAllowedTypes('number_of_replicas', 'integer');
    }
    
    private function getClient() : Client
    {
        if (null === $this->client) {
            $this->client = ClientBuilder::create()->build();
        }

        return $this->client;
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
