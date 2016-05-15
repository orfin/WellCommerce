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

namespace WellCommerce\Bundle\SearchBundle\Indexer;

use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\SearchBundle\Adapter\SearchAdapterInterface;
use WellCommerce\Bundle\SearchBundle\Factory\DocumentFactoryInterface;
use ZendSearch\Lucene\Document;

/**
 * Class ZendLuceneIndexer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ZendLuceneIndexer implements IndexerInterface
{
    private $adapter;
    
    private $documentFactory;
    
    public function __construct(SearchAdapterInterface $adapter, DocumentFactoryInterface $documentFactory)
    {
        $this->adapter         = $adapter;
        $this->documentFactory = $documentFactory;
    }
    
    public function index(EntityInterface $entity)
    {
        $document = $this->createDocument($entity);
        $this->adapter->addDocument($this->indexName, $document);
    }
    
    public function deindex(EntityInterface $entity)
    {
        $this->adapter->removeDocument($this->indexName, $entity->getId());
    }
    
    private function createDocument(EntityInterface $entity) : Document
    {
        return $this->documentFactory->createDocument($entity);
    }
}
