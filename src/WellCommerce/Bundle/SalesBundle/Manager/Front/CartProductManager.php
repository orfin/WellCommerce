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

namespace WellCommerce\Bundle\SalesBundle\Manager\Front;

use WellCommerce\Bundle\SalesBundle\Entity\CartInterface;
use WellCommerce\Bundle\SalesBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\SalesBundle\Exception\DeleteCartItemException;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\CatalogBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\CatalogBundle\Entity\ProductInterface;

/**
 * Class CartProductManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductManager extends AbstractFrontManager implements CartProductManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function initCartProduct(
        CartInterface $cart,
        ProductInterface $product,
        ProductAttributeInterface $attribute = null,
        $quantity = 1
    ) {
        $cartProduct = $this->initResource();
        $cartProduct->setCart($cart);
        $cartProduct->setProduct($product);
        $cartProduct->setAttribute($attribute);
        $cartProduct->setQuantity($quantity);

        return $cartProduct;
    }

    /**
     * {@inheritdoc}
     */
    public function findProductInCart(CartInterface $cart, ProductInterface $product, ProductAttributeInterface $attribute = null)
    {
        return $this->getRepository()->findOneBy([
            'cart'      => $cart,
            'product'   => $product,
            'attribute' => $attribute
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function addProductToCart(
        CartInterface $cart,
        ProductInterface $product,
        ProductAttributeInterface $attribute = null,
        $quantity = 1
    ) {
        $cartProduct = $this->findProductInCart($cart, $product, $attribute);

        if (null === $cartProduct) {
            $cartProduct = $this->initCartProduct($cart, $product, $attribute, $quantity);
            $cart->addProduct($cartProduct);
        } else {
            $cartProduct->increaseQuantity($quantity);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCartProductFromCart(CartProductInterface $cartProduct, CartInterface $cart)
    {
        $resource = $this->getCartProductInCart($cartProduct, $cart);
        if (null === $resource) {
            throw new DeleteCartItemException($cartProduct->getId());
        }
        $this->removeResource($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function changeCartProductQuantity(CartInterface $cart, CartProductInterface $cartProduct, $qty)
    {
        $qty = (int)$qty;

        if ($qty < 1) {
            $this->deleteCartProductFromCart($cartProduct, $cart);
        } else {
            $resource = $this->getCartProductInCart($cartProduct, $cart);
            $resource->setQuantity($qty);
            $this->updateResource($resource);
        }
    }

    /**
     * Returns an item from cart
     *
     * @param CartProductInterface $cartProduct
     * @param CartInterface        $cart
     *
     * @return null|CartProductInterface
     */
    protected function getCartProductInCart(CartProductInterface $cartProduct, CartInterface $cart)
    {
        return $this->getRepository()->findOneBy([
            'id'   => $cartProduct->getId(),
            'cart' => $cart
        ]);
    }
}
