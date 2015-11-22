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

namespace WellCommerce\SalesBundle\Manager\Front;

use WellCommerce\CatalogBundle\Entity\ProductAttributeInterface;
use WellCommerce\CatalogBundle\Entity\ProductInterface;
use WellCommerce\AppBundle\Manager\Front\FrontManagerInterface;
use WellCommerce\SalesBundle\Entity\CartInterface;
use WellCommerce\SalesBundle\Entity\CartProductInterface;

/**
 * Interface CartProductManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartProductManagerInterface extends FrontManagerInterface
{
    /**
     * Initializes product object
     *
     * @param CartInterface                  $cart
     * @param ProductInterface               $product
     * @param ProductAttributeInterface|null $attribute
     * @param int                            $quantity
     *
     * @return \WellCommerce\SalesBundle\Entity\CartProductInterface
     */
    public function initCartProduct(
        CartInterface $cart,
        ProductInterface $product,
        ProductAttributeInterface $attribute = null,
        $quantity = 1
    );


    /**
     * Removes a product from cart
     *
     * @param CartProductInterface $cartProduct
     * @param CartInterface        $cart
     */
    public function deleteCartProductFromCart(CartProductInterface $cartProduct, CartInterface $cart);

    /**
     * Returns the CartProduct object from cart or null if it was not found
     *
     * @param CartInterface                  $cart
     * @param ProductInterface               $product
     * @param ProductAttributeInterface|null $attribute
     *
     * @return null|\WellCommerce\SalesBundle\Entity\CartProductInterface
     */
    public function findProductInCart(CartInterface $cart, ProductInterface $product, ProductAttributeInterface $attribute = null);

    /**
     * Adds a new product to cart or increments its quantity
     *
     * @param CartInterface                  $cart
     * @param ProductInterface               $product
     * @param ProductAttributeInterface|null $attribute
     * @param int                            $quantity
     */
    public function addProductToCart(
        CartInterface $cart,
        ProductInterface $product,
        ProductAttributeInterface $attribute = null,
        $quantity = 1
    );

    /**
     * Changes products quantity or deletes it from cart if 0 quantity was given
     *
     * @param CartProductInterface $cartProduct
     * @param int                  $qty
     */
    public function changeCartProductQuantity(CartInterface $cart, CartProductInterface $cartProduct, $qty);
}
