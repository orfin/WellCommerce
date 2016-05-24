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

use WellCommerce\Bundle\SearchBundle\Adapter\AdapterInterface;
use WellCommerce\Bundle\SearchBundle\Builder\SearchQueryBuilderInterface;

/**
 * Interface SearchEngineManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchEngineManagerInterface
{
    public function getAdapter() : AdapterInterface;
    
    public function search(SearchQueryBuilderInterface $queryBuilder, string $type) : array;
}
