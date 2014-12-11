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

namespace WellCommerce\Bundle\ProductBundle\Collection\Item;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class ItemCollection
 *
 * @package WellCommerce\Bundle\ProductBundle\Collection\Item
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ItemCollection extends AbstractCollection
{
    public function add(ItemInterface $item)
    {
        $this->items[] = $item;
    }
} 