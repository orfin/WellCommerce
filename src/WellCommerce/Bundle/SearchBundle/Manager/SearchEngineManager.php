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
use WellCommerce\Bundle\SearchBundle\Adapter\AdapterInterface;
use WellCommerce\Bundle\SearchBundle\Builder\SearchQueryBuilderCollection;
use WellCommerce\Bundle\SearchBundle\Builder\SearchQueryBuilderInterface;

/**
 * Class SearchEngineManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchEngineManager implements SearchEngineManagerInterface
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var SearchQueryBuilderCollection
     */
    private $builders;

    /**
     * @var SearchResultStorage
     */
    private $storage;

    /**
     * SearchEngineManager constructor.
     *
     * @param AdapterInterface             $adapter
     * @param SearchQueryBuilderCollection $builders
     * @param SearchResultStorage          $storage
     */
    public function __construct(AdapterInterface $adapter, SearchQueryBuilderCollection $builders, SearchResultStorage $storage)
    {
        $this->adapter       = $adapter;
        $this->builders = $builders;
        $this->storage       = $storage;
    }

    public function getAdapter() : AdapterInterface
    {
        return $this->adapter;
    }
    
    public function search(SearchQueryBuilderInterface $queryBuilder, string $type) : array
    {
        $results = $this->adapter->search($queryBuilder, $type);

        $this->storage->setResult($results);

        return $results;
    }
}
