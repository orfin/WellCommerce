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

namespace WellCommerce\Component\DataSet\Cache;

use Doctrine\ORM\Query;

/**
 * Interface DataSetCacheManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetCacheManagerInterface
{
    public function getCachedDataSetResult(Query $query, CacheOptions $options) : array;
}
