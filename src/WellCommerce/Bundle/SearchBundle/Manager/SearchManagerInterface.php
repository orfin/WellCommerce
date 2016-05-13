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

use WellCommerce\Bundle\SearchBundle\Indexer\IndexerInterface;
use WellCommerce\Bundle\SearchBundle\Provider\ResultProviderInterface;
use WellCommerce\Bundle\SearchBundle\Query\SearchQuery;

/**
 * Interface SearchManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchManagerInterface
{
    public function getIndexer() : IndexerInterface;

    public function getProvider() : ResultProviderInterface;

    public function createIndex();
    
    public function getIndex();
    
    public function removeIndex();
    
    public function eraseIndex();
    
    public function reindex();

    public function search(SearchQuery $query) : array;

    public function getResultIdentifiers() : array;
}
