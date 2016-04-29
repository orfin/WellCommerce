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

namespace WellCommerce\Bundle\OrderBundle\Manager;

use WellCommerce\Bundle\CoreBundle\Manager\Front\FrontManagerInterface;
use WellCommerce\Bundle\OrderBundle\Entity\CartInterface;
use WellCommerce\Bundle\OrderBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Interface CartManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderCartManagerInterface extends FrontManagerInterface
{
    /**
     * Adds new product to cart
     *
     * @param ProductInterface $product
     * @param VariantInterface $variant
     * @param int              $quantity
     *
     * @return bool
     */
    public function addProductToCart(ProductInterface $product, VariantInterface $variant = null, $quantity = 1);

    /**
     * Deletes the item from cart
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteCartProduct(CartProductInterface $cartProduct);

    /**
     * Changes item quantity on cart
     *
     * @param int $id
     * @param int $qty
     *
     * @return bool
     */
    public function changeCartProductQuantity(CartProductInterface $cartProduct, $qty);

    /**
     * Initializes the cart for current request
     *
     * @return CartInterface
     */
    public function initializeCart();

    public function abandonCurrentCart();
}
