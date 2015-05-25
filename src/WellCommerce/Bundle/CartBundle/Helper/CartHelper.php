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
use WellCommerce\Bundle\CartBundle\Repository\CartProductRepositoryInterface;
use WellCommerce\Bundle\CartBundle\Repository\CartRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\MultiStoreBundle\Context\ShopContextInterface;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;

/**
 * Class CartHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartHelper implements CartHelperInterface
{
    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @var CartProductRepositoryInterface
     */
    protected $cartProductRepository;

    /**
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * @var ShopContextInterface
     */
    protected $shopContext;

    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;

    /**
     * Constructor
     *
     * @param CartRepositoryInterface        $cartRepository
     * @param CartProductRepositoryInterface $cartProductRepository
     * @param RequestHelperInterface         $requestHelper
     * @param ShopContextInterface           $shopContext
     * @param DoctrineHelperInterface        $doctrineHelper
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        CartProductRepositoryInterface $cartProductRepository,
        RequestHelperInterface $requestHelper,
        ShopContextInterface $shopContext,
        DoctrineHelperInterface $doctrineHelper
    ) {
        $this->cartRepository        = $cartRepository;
        $this->cartProductRepository = $cartProductRepository;
        $this->requestHelper         = $requestHelper;
        $this->shopContext           = $shopContext;
        $this->doctrineHelper        = $doctrineHelper;
    }

    /**
     * @return null|Cart
     */
    public function getCart()
    {
        $client    = $this->requestHelper->getClient();
        $sessionId = $this->requestHelper->getSessionId();
        $shop      = $this->shopContext->getCurrentScope();
        $cart      = $this->cartRepository->getCart($client, $sessionId, $shop);
        $em        = $this->doctrineHelper->getEntityManager();

        if (null === $cart) {
            $cart = $this->initCart();
            $em->persist($cart);
        } else {
            $cart->setClient($client);
            $cart->setSessionId($sessionId);
        }

        $em->flush();

        return $cart;
    }

    /**
     * @param Product          $product
     * @param ProductAttribute $attribute
     *
     * @return null|CartProduct
     */
    public function getCartProduct(Product $product, ProductAttribute $attribute = null)
    {
        return $this->cartProductRepository->findProductInCart($this->getCart(), $product, $attribute);
    }

    public function abandonCart()
    {
        $cart = $this->getCart();
        $em   = $this->doctrineHelper->getEntityManager();
        $em->clear($cart);
        $em->flush();
    }

    /**
     * @param CartProduct $cartProduct
     */
    public function deleteCartProduct(CartProduct $cartProduct)
    {
        $em = $this->doctrineHelper->getEntityManager();
        $this->getCart()->getProducts()->removeElement($cartProduct);
        $em->flush();
    }

    /**
     * @param CartProduct $cartProduct
     * @param int         $quantity
     */
    public function changeCartProductQuantity(CartProduct $cartProduct, $quantity)
    {
        $em = $this->doctrineHelper->getEntityManager();
        $cartProduct->setQuantity($quantity);
        $em->flush();
    }

    /**
     * @param Product          $product
     * @param ProductAttribute $attribute
     * @param int              $quantity
     */
    public function addProductToCart(Product $product, ProductAttribute $attribute = null, $quantity)
    {
        $em          = $this->doctrineHelper->getEntityManager();
        $cartProduct = $this->getCartProduct($product, $attribute);

        if (null === $cartProduct) {
            $cartProduct = new CartProduct();
            $cartProduct->setCart($this->getCart());
            $cartProduct->setProduct($product);
            $cartProduct->setAttribute($attribute);
            $cartProduct->setQuantity($quantity);
            $em->persist($cartProduct);
        } else {
            $cartProduct->setQuantity($cartProduct->getQuantity() + (int)$quantity);
        }

        $em->flush();
    }

    /**
     * @return Cart
     */
    protected function initCart()
    {
        $client    = $this->requestHelper->getClient();
        $sessionId = $this->requestHelper->getSessionId();
        $shop      = $this->shopContext->getCurrentScope();

        $cart = new Cart();
        $cart->setClient($client);
        $cart->setSessionId($sessionId);
        $cart->setShop($shop);

        return $cart;
    }
}
