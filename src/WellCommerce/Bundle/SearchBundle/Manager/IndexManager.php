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

namespace WellCommerce\Bundle\SearchBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Console\Output\OutputInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\SearchBundle\Adapter\SearchAdapterInterface;
use WellCommerce\Bundle\SearchBundle\Factory\DocumentFactoryInterface;
use WellCommerce\Bundle\SearchBundle\Query\SearchQuery;
use WellCommerce\Bundle\SearchBundle\Storage\SearchResultStorage;

/**
 * Class SearchManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class IndexManager
{
    /**
     * @var string
     */
    private $indexName;
    
    /**
     * @var DocumentFactoryInterface
     */
    private $documentFactory;
    
    /**
     * @var SearchAdapterInterface
     */
    private $adapter;
    
    /**
     * @var RepositoryInterface
     */
    private $repository;
    
    private $storage;
    
    /**
     * IndexManager constructor.
     *
     * @param string                   $indexName
     * @param DocumentFactoryInterface $documentFactory
     * @param SearchAdapterInterface   $adapter
     * @param RepositoryInterface      $repository
     * @param SearchResultStorage      $storage
     */
    public function __construct(
        string $indexName,
        DocumentFactoryInterface $documentFactory,
        SearchAdapterInterface $adapter,
        RepositoryInterface $repository,
        SearchResultStorage $storage
    ) {
        $this->indexName       = $indexName;
        $this->documentFactory = $documentFactory;
        $this->adapter         = $adapter;
        $this->repository      = $repository;
        $this->storage         = $storage;
    }
    
    public function getIndexName() : string
    {
        return $this->indexName;
    }
    
    public function getTotalEntities() : int
    {
        return $this->repository->getTotalCount();
    }
    
    public function getEntitiesCollection(Criteria $criteria) : Collection
    {
        $result = $this->repository->findBy([], null, $criteria->getMaxResults(), $criteria->getFirstResult());
        
        return new ArrayCollection($result);
    }
    
    public function addEntity(EntityInterface $entity)
    {
        $document = $this->documentFactory->createDocument($entity);
        $this->adapter->add($document);
    }
    
    public function updateEntity(EntityInterface $entity)
    {
        $document = $this->documentFactory->createDocument($entity);
        $this->adapter->update($entity->getId(), $document);
    }
    
    public function removeEntity(EntityInterface $entity)
    {
        $this->adapter->remove($entity->getId());
    }
    
    public function optimizeIndex()
    {
        $this->adapter->optimize();
    }
    
    public function purgeIndex()
    {
        $this->adapter->purge();
    }
    
    public function search(SearchQuery $query) : array
    {
        $result = $this->adapter->search($query);
        
        $this->storage->setResult($result);

        return $result;
    }
}
