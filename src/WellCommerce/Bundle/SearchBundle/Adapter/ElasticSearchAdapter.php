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

use Doctrine\Common\Collections\Collection;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\SearchBundle\Builder\SearchQueryBuilderInterface;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;
use WellCommerce\Bundle\SearchBundle\Document\Field\DocumentFieldInterface;

/**
 * Class ElasticSearchAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ElasticSearchAdapter implements SearchAdapterInterface
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
     * @var string|null
     */
    private $index = null;

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
        $this->client  = $this->createClient();
    }
    
    public function search(SearchQueryBuilderInterface $builder, string $type) : array
    {
        $params = [
            'index' => $this->getIndex(),
            'type'  => $type,
            'size'  => 100,
            'body'  => [
                'query' => $builder->getQuery()
            ]
        ];

        $results = $this->client->search($params);

        return $this->processResults($results);
    }
    
    public function addDocument(DocumentInterface $document)
    {
        $body = [];
        
        $document->getFields()->map(function (DocumentFieldInterface $field) use (&$body) {
            $body[$field->getName()] = $field->getValue();
        });
        
        $params = [
            'index' => $this->getIndex(),
            'type'  => $document->getType(),
            'id'    => $document->getIdentifier(),
            'body'  => $body
        ];
        
        $this->client->index($params);
    }

    public function addDocuments(Collection $collection)
    {
        $params = ['body' => []];

        $collection->map(function (DocumentInterface $document) use ($params) {
            $params['body'][] = [
                'index' => [
                    '_index' => $this->getIndex(),
                    '_type'  => $document->getType(),
                    '_id'    => $document->getIdentifier()
                ]
            ];

            $body = [];

            $document->getFields()->map(function (DocumentFieldInterface $field) use (&$body) {
                $body[$field->getName()] = $field->getValue();
            });

            $params['body'][] = $body;

            $this->client->bulk($params);
        });
    }
    
    public function removeDocument(DocumentInterface $document)
    {
        $params = [
            'index' => $this->getIndex(),
            'type'  => $document->getType(),
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
            'type'  => $document->getType(),
            'id'    => $document->getIdentifier(),
            'body'  => $body
        ];
        
        $this->client->update($params);
    }
    
    public function createIndex()
    {
        return $this->client->indices()->create([
            'index' => $this->options['index_name'],
            'body'  => [
                'settings' => [
                    'number_of_shards'   => $this->options['number_of_shards'],
                    'number_of_replicas' => $this->options['number_of_replicas']
                ]
            ]
        ]);
    }
    
    public function removeIndex()
    {
        return $this->client->indices()->delete([
            'index' => $this->getIndex()
        ]);
    }
    
    public function flushIndex()
    {
        return $this->client->indices()->flush([
            'index' => $this->getIndex()
        ]);
    }

    public function optimizeIndex()
    {
        return $this->client->indices()->optimize([
            'index' => $this->getIndex()
        ]);
    }
    
    public function getStats()
    {
        return $this->client->indices()->stats([
            'index' => $this->getIndex()
        ]);
    }
    
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'index_name',
            'number_of_shards',
            'number_of_replicas',
        ]);
        
        $resolver->setDefault('settings', []);
        $resolver->setDefault('number_of_shards', 2);
        $resolver->setDefault('number_of_replicas', 0);

        $resolver->setAllowedTypes('index_name', 'string');
        $resolver->setAllowedTypes('number_of_shards', 'integer');
        $resolver->setAllowedTypes('number_of_replicas', 'integer');
    }
    
    private function hasIndex() : bool
    {
        return $this->client->indices()->exists([
            'index' => $this->options['index_name']
        ]);
    }
    
    private function createClient() : Client
    {
        return ClientBuilder::create()->build();
    }
    
    private function getIndex()
    {
        if (null === $this->index) {

            if (false === $this->hasIndex()) {
                $this->createIndex();
            }

            $this->index = $this->options['index_name'];
        }

        return $this->index;
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
