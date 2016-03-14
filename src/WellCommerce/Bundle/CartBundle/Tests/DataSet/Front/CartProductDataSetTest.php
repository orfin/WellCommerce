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

namespace WellCommerce\Bundle\CartBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class CartProductDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('cart_product.dataset');
    }

    protected function getColumns()
    {
        return [
            'id'              => 'cart_product.id',
            'price'           => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.sellPrice.grossAmount, product.sellPrice.grossAmount)',
            'discountedPrice' => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.sellPrice.discountedGrossAmount, product.sellPrice.discountedGrossAmount)',
            'currency'        => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.sellPrice.currency, product.sellPrice.currency)',
            'stock'           => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.stock, product.stock)',
            'weight'          => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.weight, product.weight)',
            'quantity'        => 'cart_product.quantity',
            'attribute'       => 'IDENTITY(cart_product.variant)',
            'name'            => 'product_translation.name',
            'route'           => 'IDENTITY(product_translation.route)',
            'isDiscountValid' => 'IF_ELSE(:date BETWEEN product.sellPrice.validFrom AND product.sellPrice.validTo, 1, 0)',
            'tax'             => 'sell_tax.value',
            'photo'           => 'photos.path'
        ];
    }
}
