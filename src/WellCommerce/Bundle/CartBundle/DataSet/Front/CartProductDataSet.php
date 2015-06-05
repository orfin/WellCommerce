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

namespace WellCommerce\Bundle\CartBundle\DataSet\Front;

use WellCommerce\Bundle\DataSetBundle\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\DataSetConfiguratorInterface;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;

/**
 * Class CartProductDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'               => 'cart_product.id',
            'quantity'         => 'cart_product.quantity',
            'attribute'        => 'IDENTITY(cart_product.attribute)',
            'name'             => 'product_translation.name',
            'route'            => 'IDENTITY(product_translation.route)',
            'weight'           => 'product.weight',
            'price'            => 'product.sellPrice.amount',
            'currency'         => 'product.sellPrice.currency',
            'tax'              => 'product.sellPrice.tax',
            'stock'            => 'product.stock',
            'photo'            => 'photos.path'
        ]);
    }
}
