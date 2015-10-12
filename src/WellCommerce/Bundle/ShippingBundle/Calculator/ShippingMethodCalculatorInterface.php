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
 * Interface ShippingMethodCalculatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodCalculatorInterface
{
    /**
     * Returns alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Returns name
     *
     * @return string
     */
    public function getName();

    /**
     * Calculates the costs of cart for particular shipping method
     *
     * @param ShippingMethodInterface $shippingMethod
     * @param ProductInterface        $product
     *
     * @return null|\WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface
     */
    public function calculateProduct(ShippingMethodInterface $shippingMethod, ProductInterface $product);

    /**
     * Calculates the costs of cart for particular shipping method
     *
     * @param ShippingMethodInterface $shippingMethod
     * @param CartInterface           $cart
     *
     * @return null|\WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface
     */
    public function calculateCart(ShippingMethodInterface $shippingMethod, CartInterface $cart);
}

