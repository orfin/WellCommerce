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

use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\SearchBundle\Adapter\SearchAdapterInterface;

/**
 * Class SearchIndexManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchIndexManager implements SearchIndexManagerInterface
{
    /**
     * @var string
     */
    private $indexName;
    
    /**
     * @var SearchAdapterInterface
     */
    private $adapter;
    
    /**
     * @var RepositoryInterface
     */
    private $repository;
    
    /**
     * @var array
     */
    private $mappings;
    
    /**
     * SearchIndexManager constructor.
     *
     * @param string                 $indexName
     * @param SearchAdapterInterface $adapter
     * @param RepositoryInterface    $repository
     * @param array                  $mappings
     */
    public function __construct(string $indexName, SearchAdapterInterface $adapter, RepositoryInterface $repository, array $fields)
    {
        $this->indexName  = $indexName;
        $this->adapter    = $adapter;
        $this->repository = $repository;
        $this->mappings   = $mappings;
    }
    
    public function search()
    {
        
    }
    
    public function getTotalEntities() : array
    {
        return $this->repository->getTotalCount();
    }
}
