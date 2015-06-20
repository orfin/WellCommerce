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
namespace WellCommerce\Bundle\CartBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Event\CartEvent;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartManager;
use WellCommerce\Bundle\ClientBundle\Entity\Client;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;

/**
 * Class CartSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            CartManager::CART_CHANGED_EVENT => ['onCartChangedEvent', 0],
            KernelEvents::CONTROLLER        => ['onKernelController', -256],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if ($event->isMasterRequest()) {
            $requestHelper       = $this->container->get('request_helper');
            $shop                = $this->container->get('shop.context.front')->getCurrentScope();
            $sessionId           = $requestHelper->getSessionId();
            $client              = $requestHelper->getClient();
            $cartProvider        = $this->container->get('cart.provider');
            $cart                = $this->getCart($shop, $client, $sessionId);
            $cartSummaryProvider = $this->container->get('cart_summary.provider');
            $cartQueryBuilder    = $this->container->get('cart_product.dataset.query_builder.front');

            $cartProvider->setCurrentCart($cart);
            $cartSummaryProvider->setCart($cart);
            $cartQueryBuilder->setCart($cart);
        }
    }

    /**
     * Returns current cart from repository and creates a new one in needed
     *
     * @param Shop   $shop
     * @param Client $client
     * @param string $sessionId
     *
     * @return null|object|Cart
     */
    protected function getCart(Shop $shop, Client $client = null, $sessionId)
    {
        $doctrineHelper = $this->container->get('doctrine_helper');
        $entityManager  = $doctrineHelper->getEntityManager();
        $cartRepository = $this->container->get('cart.repository');

        $cart = $cartRepository->getCart($client, $sessionId, $shop);
        if (null === $cart) {
            $cart = $this->initCart($shop, $client, $sessionId);
            $entityManager->persist($cart);
        } else {
            $cart->setClient($client);
            $cart->setSessionId($sessionId);
        }

        $entityManager->flush();

        return $cart;
    }

    /**
     * Initializes cart
     *
     * @param Shop   $shop
     * @param Client $client
     * @param string $sessionId
     *
     * @return Cart
     */
    protected function initCart(Shop $shop, Client $client = null, $sessionId)
    {
        $cart = new Cart();
        $cart->setShop($shop);
        $cart->setClient($client);
        $cart->setSessionId($sessionId);
        $cart->setPaymentMethod($this->getPaymentMethodRepository()->getDefaultPaymentMethod());
        $cart->setShippingMethod($this->getShippingMethodRepository()->getDefaultShippingMethod());

        return $cart;
    }

    /**
     * @return \WellCommerce\Bundle\PaymentBundle\Repository\PaymentMethodRepositoryInterface
     */
    private function getPaymentMethodRepository()
    {
        return $this->container->get('payment_method.repository');
    }

    /**
     * @return \WellCommerce\Bundle\ShippingBundle\Repository\ShippingMethodRepositoryInterface
     */
    private function getShippingMethodRepository()
    {
        return $this->container->get('shipping_method.repository');
    }

    public function onCartChangedEvent(CartEvent $cartEvent)
    {
        $cart   = $cartEvent->getCart();
        $helper = $this->container->get('cart.helper');

        return $helper->recalculateCartTotals($cart);
    }
}
