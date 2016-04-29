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

namespace WellCommerce\Bundle\OrderBundle\DataSet\Front;

use WellCommerce\Bundle\OrderBundle\Entity\Cart;
use WellCommerce\Bundle\OrderBundle\Entity\CartProduct;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\Variant;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

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
            'id'              => 'cart_product.id',
            'price'           => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.sellPrice.grossAmount, product.sellPrice.grossAmount)',
            'discountedPrice' => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.sellPrice.discountedGrossAmount, product.sellPrice.discountedGrossAmount)',
            'currency'        => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.sellPrice.currency, product.sellPrice.currency)',
            'stock'           => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.stock, product.stock)',
            'weight'          => 'IF_ELSE(cart_product.variant IS NOT NULL, product_variant.weight, product.weight)',
            'quantity'        => 'cart_product.quantity',
            'variant'         => 'IDENTITY(cart_product.variant)',
            'options'         => 'cart_product.options',
            'name'            => 'product_translation.name',
            'route'           => 'IDENTITY(product_translation.route)',
            'isDiscountValid' => 'IF_ELSE(:date BETWEEN product.sellPrice.validFrom AND product.sellPrice.validTo, 1, 0)',
            'tax'             => 'sell_tax.value',
            'photo'           => 'photos.path'
        ]);

        $configurator->setColumnTransformers([
            'route' => $this->getDataSetTransformer('route'),
        ]);

        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Cart::class,
            CartProduct::class,
            Product::class,
            Variant::class,
            Tax::class
        ]));
    }
}
