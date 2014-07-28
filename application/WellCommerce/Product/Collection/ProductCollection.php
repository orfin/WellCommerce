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

namespace WellCommerce\Product\Collection;

/**
 * Class ProductCollection
 *
 * @package WellCommerce\Product\Collection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductCollection
{

    public function addColumns()
    {
        $this->columns->add(new Source([
            'id'         => 'id',
            'source'     => 'product.id',
        ]));

        $this->columns->add(new Source([
            'id'         => 'name',
            'source'     => 'product_translation.name',
        ]));
    }
} 