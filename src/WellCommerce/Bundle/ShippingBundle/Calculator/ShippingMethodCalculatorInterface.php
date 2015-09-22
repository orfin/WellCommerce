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
     * Checks whether calculator can handle product
     *
     * @param ShippingMethodInterface $shippingMethod
     * @param ProductInterface        $product
     *
     * @return bool
     */
    public function supportsProduct(ShippingMethodInterface $shippingMethod, ProductInterface $product);

    /**
     * Checks whether calculator can handle cart
     *
     * @param ShippingMethodInterface $shippingMethod
     * @param CartInterface           $cart
     *
     * @return bool
     */
    public function supportsCart(ShippingMethodInterface $shippingMethod, CartInterface $cart);

    /**
     * Calculates the costs of product for particular shipping method
     *
     * @param ShippingMethodInterface $shippingMethod
     * @param ProductInterface        $product
     *
     * @return \WellCommerce\Bundle\ShippingBundle\Calculator\ShippingCostReference
     */
    public function calculateProduct(ShippingMethodInterface $shippingMethod, ProductInterface $product);

    /**
     * Calculates the costs of cart for particular shipping method
     *
     * @param ShippingMethodInterface $shippingMethod
     * @param CartInterface           $cart
     *
     * @return \WellCommerce\Bundle\ShippingBundle\Calculator\ShippingCostReference
     */
    public function calculateCart(ShippingMethodInterface $shippingMethod, CartInterface $cart);
}

