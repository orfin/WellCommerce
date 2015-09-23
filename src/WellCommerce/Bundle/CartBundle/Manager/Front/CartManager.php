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

namespace WellCommerce\Bundle\CartBundle\Manager\Front;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CartBundle\EventDispatcher\CartEventDispatcherInterface;
use WellCommerce\Bundle\CartBundle\Exception\AddCartItemException;
use WellCommerce\Bundle\CartBundle\Factory\CartFactoryInterface;
use WellCommerce\Bundle\CartBundle\Repository\CartRepositoryInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class CartManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CartManager extends AbstractFrontManager implements CartManagerInterface
{
    /**
     * @var CartProductManagerInterface
     */
    protected $cartProductManager;

    /**
     * Constructor
     *
     * @param CartRepositoryInterface      $cartRepository
     * @param FactoryInterface             $cartFactory
     * @param CartEventDispatcherInterface $eventDispatcher
     * @param CartProductManagerInterface  $cartProductManager
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        FactoryInterface $cartFactory,
        CartEventDispatcherInterface $eventDispatcher,
        CartProductManagerInterface $cartProductManager
    ) {
        parent::__construct($cartRepository, $cartFactory, $eventDispatcher);
        $this->cartProductManager = $cartProductManager;
    }

    /**
     * {@inheritdoc}
     */
    public function addProductToCart(ProductInterface $product, ProductAttributeInterface $attribute = null, $quantity = 1)
    {
        try {
            $cart        = $this->getCurrentCart();
            $cartProduct = $this->cartProductManager->findProductInCart($cart, $product, $attribute);

            if (null === $cartProduct) {
                $cartProduct = $this->cartProductManager->initCartProduct($cart, $product, $attribute, $quantity);
                $cart->addProduct($cartProduct);
            } else {
                $cartProduct->increaseQuantity($quantity);
            }

            $this->updateResource($cart);

        } catch (\Exception $e) {
            throw new AddCartItemException($product, $attribute, $quantity, $e);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCartProduct(CartProductInterface $cartProduct)
    {
        $this->cartProductManager->removeResource($cartProduct);
        $this->updateResource($this->getCurrentCart());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function changeCartProductQuantity(CartProductInterface $cartProduct, $qty)
    {
        $this->cartProductManager->changeCartProductQuantity($cartProduct, $qty);
        $this->updateResource($this->getCurrentCart());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeCart()
    {
        $requestHelper = $this->getRequestHelper();
        $sessionId     = $requestHelper->getSessionId();
        $client        = $requestHelper->getClient();
        $shop          = $this->getShopContext()->getCurrentScope();
        $cart          = $this->getCart($shop, $client, $sessionId);

        $cartProvider = $this->getCartProvider();
        $cartProvider->setCurrentCart($cart);
    }

    /**
     * Returns an existent cart or creates a new one if needed
     *
     * @param ShopInterface        $shop
     * @param ClientInterface|null $client
     * @param string               $sessionId
     *
     * @return CartInterface
     */
    protected function getCart(ShopInterface $shop, ClientInterface $client = null, $sessionId)
    {
        /** @var $cartRepository CartRepositoryInterface */
        $cartRepository = $this->getRepository();
        $cart           = $cartRepository->findCart($client, $sessionId, $shop);

        if (null === $cart) {
            $cart = $this->createCart($shop, $client, $sessionId);
        } else {
            $this->updateCartClient($cart, $client);
        }

        return $cart;
    }

    /**
     * Updates client relation only when changed and not null
     *
     * @param CartInterface        $cart
     * @param ClientInterface|null $client
     */
    protected function updateCartClient(CartInterface $cart, ClientInterface $client = null)
    {
        if (null !== $client && null === $cart->getClient()) {
            $cart->setClient($client);
            $this->updateResource($cart);
        }
    }

    /**
     * Creates cart using factory
     *
     * @param ShopInterface        $shop
     * @param ClientInterface|null $client
     * @param string               $sessionId
     *
     * @return CartInterface
     */
    protected function createCart(ShopInterface $shop, ClientInterface $client = null, $sessionId)
    {
        $cart = $this->initResource();
        $cart->setShop($shop);
        $cart->setSessionId($sessionId);

        if (null !== $client) {
            $cart->setClient($client);
        }

        $this->createResource($cart);

        return $cart;
    }
}
