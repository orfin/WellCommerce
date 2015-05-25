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

use WellCommerce\Bundle\CartBundle\Entity\CartProduct;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;

/**
 * Interface CartHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartHelperInterface {

    /**
     * @return null|\WellCommerce\Bundle\CartBundle\Entity\Cart
     */
    public function getCart();

    /**
     * @param Product          $product
     * @param ProductAttribute $attribute
     *
     * @return null|CartProduct
     */
    public function getCartProduct(Product $product, ProductAttribute $attribute = null);

    /**
     * @return void
     */
    public function abandonCart();

    /**
     * @param CartProduct $cartProduct
     */
    public function deleteCartProduct(CartProduct $cartProduct);

    /**
     * @param CartProduct $cartProduct
     * @param int         $quantity
     */
    public function changeCartProductQuantity(CartProduct $cartProduct, $quantity);

    /**
     * @param Product          $product
     * @param ProductAttribute $attribute
     * @param int              $quantity
     */
    public function addProductToCart(Product $product, ProductAttribute $attribute = null, $quantity);
}