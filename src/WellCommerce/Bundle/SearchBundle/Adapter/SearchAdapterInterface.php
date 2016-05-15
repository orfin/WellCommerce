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

use WellCommerce\Bundle\SearchBundle\Query\SearchQuery;

/**
 * Interface SearchAdapterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchAdapterInterface
{
    public function search(SearchQuery $query) : array;
    
    public function add($document);
    
    public function remove(int $identifier);
    
    public function update(int $identifier, $document);
    
    public function purge();

    public function optimize();
}
