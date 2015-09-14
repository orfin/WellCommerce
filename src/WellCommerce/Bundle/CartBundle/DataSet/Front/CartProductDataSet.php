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

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\Configurator\DataSetConfiguratorInterface;

/**
 * Class CartProductDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'                      => 'cart_product.id',
            'quantity'                => 'cart_product.quantity',
            'quantityPrice'           => 'cart_product.quantity * product.sellPrice.amount',
            'quantityDiscountedPrice' => 'cart_product.quantity * product.sellPrice.discountedAmount',
            'attribute'               => 'IDENTITY(cart_product.attribute)',
            'name'                    => 'product_translation.name',
            'route'                   => 'IDENTITY(product_translation.route)',
            'weight'                  => 'product.weight',
            'price'                   => 'product.sellPrice.amount',
            'discountedPrice'         => 'product.sellPrice.discountedAmount',
            'isDiscountValid'         => 'IF_ELSE(:date BETWEEN product.sellPrice.validFrom AND product.sellPrice.validTo, 1, 0)',
            'currency'                => 'product.sellPrice.currency',
            'tax'                     => 'sell_tax.value',
            'stock'                   => 'product.stock',
            'photo'                   => 'photos.path'
        ]);
    }
}
