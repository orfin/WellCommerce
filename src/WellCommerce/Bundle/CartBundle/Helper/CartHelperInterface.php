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

namespace WellCommerce\Bundle\CartBundle\Helper;

use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Entity\CartProduct;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;

/**
 * Interface CartHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartHelperInterface
{
    /**
     * @param Cart             $cart
     * @param Product          $product
     * @param ProductAttribute $attribute
     *
     * @return null|CartProduct
     */
    public function getCartProduct(Cart $cart, Product $product, ProductAttribute $attribute = null);

    /**
     * Removes cart from registry
     *
     * @param Cart $cart
     */
    public function abandonCart(Cart $cart);

    /**
     * Removes item from cart
     *
     * @param Cart        $cart
     * @param CartProduct $cartProduct
     */
    public function deleteCartProduct(Cart $cart, CartProduct $cartProduct);

    /**
     * @param CartProduct $cartProduct
     * @param int         $quantity
     */
    public function changeCartProductQuantity(CartProduct $cartProduct, $quantity);

    /**
     * Adds new product to cart
     *
     * @param Cart             $cart
     * @param Product          $product
     * @param ProductAttribute $attribute
     * @param int              $quantity
     */
    public function addProductToCart(Cart $cart, Product $product, ProductAttribute $attribute = null, $quantity);

}