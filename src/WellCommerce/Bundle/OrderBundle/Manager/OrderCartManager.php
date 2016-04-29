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

use WellCommerce\Bundle\OrderBundle\Entity\CartInterface;
use WellCommerce\Bundle\OrderBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\OrderBundle\Exception\AddCartItemException;
use WellCommerce\Bundle\OrderBundle\Repository\CartRepositoryInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Class CartManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderCartManager extends AbstractFrontManager implements OrderCartManagerInterface
{
    /**
     * @var CartRepositoryInterface
     */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function addProductToCart(ProductInterface $product, VariantInterface $variant = null, $quantity = 1)
    {
        $cart = $this->getCartContext()->getCurrentCart();

        try {
            $this->cartProductManager->addProductToCart($cart, $product, $variant, $quantity);
            $this->updateResource($cart);

        } catch (\Exception $e) {
            throw new AddCartItemException($product, $variant, $quantity, $e);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCartProduct(CartProductInterface $cartProduct)
    {
        $cart = $this->getCartContext()->getCurrentCart();
        $this->cartProductManager->deleteCartProductFromCart($cartProduct, $cart);
        $this->updateResource($cart);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function changeCartProductQuantity(CartProductInterface $cartProduct, $qty)
    {
        $cart = $this->getCartContext()->getCurrentCart();
        $this->cartProductManager->changeCartProductQuantity($cart, $cartProduct, $qty);
        $this->updateResource($cart);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeCart()
    {
        $requestHelper = $this->getRequestHelper();
        $sessionId     = $requestHelper->getSessionId();
        $client        = $this->getClient();
        $currency      = $requestHelper->getCurrentCurrency();
        $shop          = $this->getShopContext()->getCurrentShop();
        $cart          = $this->getCart($shop, $client, $sessionId, $currency);

        $this->getCartContext()->setCurrentCart($cart);

        return $cart;
    }

    /**
     * {@inheritdoc}
     */
    public function abandonCurrentCart()
    {
        if ($this->getCartContext()->hasCurrentCart()) {
            $this->removeResource($this->getCartContext()->getCurrentCart());
            $this->initializeCart();
        }
    }

    /**
     * Returns an existent cart or creates a new one if needed
     *
     * @param ShopInterface        $shop
     * @param ClientInterface|null $client
     * @param string               $sessionId
     * @param string               $currency
     *
     * @return CartInterface
     */
    protected function getCart(ShopInterface $shop, ClientInterface $client = null, $sessionId, $currency)
    {
        $cart = $this->repository->findCart($client, $sessionId, $shop);

        if (null === $cart) {
            $cart = $this->createCart($shop, $client);
        } else {
            $this->updateCart($cart, $client, $currency);
        }

        return $cart;
    }

    /**
     * Updates client and/or currency if changed
     *
     * @param CartInterface        $cart
     * @param ClientInterface|null $client
     * @param string               $currency
     */
    protected function updateCart(CartInterface $cart, ClientInterface $client = null, $currency)
    {
        $needsUpdate = false;

        if ($client !== $cart->getClient()) {
            $cart->setClient($client);
            $needsUpdate = true;
        }

        if ($currency !== $cart->getCurrency()) {
            $cart->setCurrency($currency);
            $needsUpdate = true;
        }

        if ($needsUpdate) {
            $this->updateResource($cart);
        }
    }

    /**
     * Creates cart using factory
     *
     * @param ShopInterface        $shop
     * @param ClientInterface|null $client
     *
     * @return CartInterface
     */
    private function createCart(ShopInterface $shop, ClientInterface $client = null) : CartInterface
    {
        $cart = $this->initResource();
        $cart->setShop($shop);
        $cart->setClient($client);
        $this->createResource($cart);

        return $cart;
    }
}
