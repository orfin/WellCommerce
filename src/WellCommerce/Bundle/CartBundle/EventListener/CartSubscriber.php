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
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CartBundle\Entity\Cart;
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
        return parent::getSubscribedEvents() + [
            KernelEvents::CONTROLLER => ['onKernelController', -256],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            $requestHelper = $this->container->get('request_helper');
            $shop          = $this->container->get('shop.context.front')->getCurrentScope();
            $sessionId     = $requestHelper->getSessionId();
            $client        = $requestHelper->getClient();
            $cartProvider  = $this->container->get('cart.provider');

            $cart = $this->getCart($shop, $client, $sessionId);
            $cartProvider->setCurrentCart($cart);
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
        $cart           = $cartRepository->getCart($client, $sessionId, $shop);

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

        return $cart;
    }
}
