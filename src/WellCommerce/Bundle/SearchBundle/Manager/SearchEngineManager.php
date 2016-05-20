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

use WellCommerce\Bundle\SearchBundle\Storage\SearchResultStorage;
use WellCommerce\Component\SearchEngine\Adapter\AdapterInterface;
use WellCommerce\Component\SearchEngine\Builder\SearchQueryBuilderInterface;

/**
 * Class SearchEngineManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchEngineManager
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var SearchQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var SearchResultStorage
     */
    private $storage;

    /**
     * SearchEngineManager constructor.
     *
     * @param AdapterInterface            $adapter
     * @param SearchQueryBuilderInterface $queryBuilder
     * @param SearchResultStorage         $storage
     */
    public function __construct(AdapterInterface $adapter, SearchQueryBuilderInterface $queryBuilder, SearchResultStorage $storage)
    {
        $this->adapter      = $adapter;
        $this->queryBuilder = $queryBuilder;
        $this->storage      = $storage;
    }

    public function getQueryBuilder() : SearchQueryBuilderInterface
    {
        return $this->queryBuilder;
    }

    public function getAdapter() : AdapterInterface
    {
        return $this->adapter;
    }
    
    public function search(SearchQueryBuilderInterface $queryBuilder, string $type)
    {
        $results = $this->adapter->search($queryBuilder, $type);

        $this->storage->setResult($results);

        return $results;
    }
}
