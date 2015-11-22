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

namespace WellCommerce\AppBundle\Tests\DataSet\Admin;

use WellCommerce\AppBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class ProductDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('product.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'          => 'product.id',
            'name'        => 'product_translation.name',
            'sku'         => 'product.sku',
            'weight'      => 'product.weight',
            'grossAmount' => 'product.sellPrice.grossAmount',
            'stock'       => 'product.stock',
            'shop'        => 'product_shops.id',
            'category'    => 'GROUP_CONCAT(DISTINCT categories_translation.name SEPARATOR \', \')',
        ];
    }
}
