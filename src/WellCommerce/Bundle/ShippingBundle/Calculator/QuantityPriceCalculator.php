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

namespace WellCommerce\Bundle\ShippingBundle\Calculator;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Class QuantityPriceCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class QuantityPriceCalculator extends AbstractShippingMethodCalculator implements ShippingMethodCalculatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Quantity dependent price';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'quantity_price';
    }

    /**
     * {@inheritdoc}
     */
    public function supportsProduct(ShippingMethodInterface $shippingMethod, ProductInterface $product)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsCart(ShippingMethodInterface $shippingMethod, CartInterface $cart)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateProduct(ShippingMethodInterface $shippingMethod, ProductInterface $product)
    {
        return new ShippingCostReference();
    }

    /**
     * {@inheritdoc}
     */
    public function calculateCart(ShippingMethodInterface $shippingMethod, CartInterface $cart)
    {
        return new ShippingCostReference();
    }
}
