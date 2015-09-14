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

namespace WellCommerce\Bundle\ProductBundle\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\Configurator\DataSetConfiguratorInterface;

/**
 * Class ProductDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'product.id',
            'name'      => 'product_translation.name',
            'sku'       => 'product.sku',
            'weight'    => 'product.weight',
            'sellPrice' => 'product.sellPrice.amount',
            'stock'     => 'product.stock',
            'shop'      => 'product_shops.id',
            'category'  => 'GROUP_CONCAT(DISTINCT categories_translation.name SEPARATOR \', \')',
        ]);
    }
}
