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

use WellCommerce\Bundle\CartBundle\Calculator\CartTotalsCalculatorInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CartBundle\EventDispatcher\CartEventDispatcherInterface;
use WellCommerce\Bundle\CartBundle\Exception\AddCartItemException;
use WellCommerce\Bundle\CartBundle\Factory\CartFactoryInterface;
use WellCommerce\Bundle\CartBundle\Factory\CartProductFactoryInterface;
use WellCommerce\Bundle\CartBundle\Repository\CartProductRepositoryInterface;
use WellCommerce\Bundle\CartBundle\Repository\CartRepositoryInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
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
     * @var CartProductRepositoryInterface
     */
    protected $cartProductRepository;

    /**
     * @var CartProductFactoryInterface
     */
    protected $cartProductFactory;

    /**
     * Constructor
     *
     * @param CartRepositoryInterface        $cartRepository
     * @param CartFactoryInterface           $cartFactory
     * @param CartEventDispatcherInterface   $eventDispatcher
     * @param CartProductRepositoryInterface $cartProductRepository
     * @param CartProductFactoryInterface    $cartProductFactory
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        CartFactoryInterface $cartFactory,
        CartEventDispatcherInterface $eventDispatcher,
        CartProductRepositoryInterface $cartProductRepository,
        CartProductFactoryInterface $cartProductFactory
    ) {
        parent::__construct($cartRepository, $cartFactory, $eventDispatcher);
        $this->cartProductRepository = $cartProductRepository;
        $this->cartProductFactory    = $cartProductFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function addProductToCart(ProductInterface $product, ProductAttributeInterface $attribute = null, $quantity = 1)
    {
        try {
            $entityManager = $this->getEntityManager();
            $cart          = $this->getCartProvider()->getCurrentCart();
            $cartProduct   = $this->cartProductRepository->findProductInCart($cart, $product, $attribute);

            if (null === $cartProduct) {
                $cartProduct = $this->cartProductFactory->create();
                $cartProduct->setCart($cart);
                $cartProduct->setProduct($product);
                $cartProduct->setAttribute($attribute);
                $cartProduct->setQuantity($quantity);

                $cart->addProduct($cartProduct);
                $entityManager->persist($cartProduct);
            } else {
                $cartProduct->increaseQuantity($quantity);
            }

            $this->dispatchPostChangeCartEvent($cart);

            $entityManager->flush();
        } catch (\Exception $e) {
            throw new AddCartItemException($product, $attribute, $quantity, $e);
        }

        return true;
    }

    protected function dispatchPostChangeCartEvent(CartInterface $cart)
    {
        /** @var $dispatcher CartEventDispatcherInterface */
        $dispatcher = $this->getEventDispatcher();
        $dispatcher->dispatchOnPostCartChange($cart);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCartProduct(CartProductInterface $cartProduct)
    {
        $entityManager = $this->getEntityManager();
        $cart          = $this->getCartProvider()->getCurrentCart();

        $cart->removeProduct($cartProduct);
        $entityManager->remove($cartProduct);

        $this->dispatchPostChangeCartEvent($cart);

        $entityManager->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function changeCartProductQuantity(CartProductInterface $cartProduct, $qty)
    {
        $entityManager = $this->getDoctrineHelper()->getEntityManager();
        $cart          = $this->getCartProvider()->getCurrentCart();
        $qty           = (int)$qty;

        if ($qty < 1) {
            return $this->deleteCartProduct($cartProduct);
        }

        $cartProduct->setQuantity($qty);

        $this->dispatchPostChangeCartEvent($cart);

        $entityManager->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function abandonCart(CartInterface $cart)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($cart);
        $entityManager->flush();
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
        $cartProvider  = $this->getCartProvider();
        $cart          = $this->getCart($shop, $client, $sessionId);

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
        $entityManager  = $this->getDoctrineHelper()->getEntityManager();

        if (null === $cart) {
            $cart = $this->createCart($shop, $client, $sessionId);
            $entityManager->persist($cart);
        }

        $cart->setSessionId($sessionId);

        if (null !== $client) {
            $cart->setClient($client);
        }

        $entityManager->flush();

        return $cart;
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
        $cart = $this->getFactory()->create();
        $cart->setShop($shop);
        $cart->setSessionId($sessionId);

        if (null !== $client) {
            $cart->setClient($client);
        }

        return $cart;
    }
}
