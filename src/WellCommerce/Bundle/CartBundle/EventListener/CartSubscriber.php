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

use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CartBundle\Event\CartEvent;
use WellCommerce\Bundle\CartBundle\EventDispatcher\CartEventDispatcher;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartManagerInterface;
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
    /**
     * @var CartManagerInterface
     */
    protected $cartManager;

    /**
     * Constructor
     *
     * @param CartManagerInterface $cartManager
     */
    public function __construct(CartManagerInterface $cartManager)
    {
        $this->cartManager = $cartManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            CartEventDispatcher::POST_CART_CHANGE_EVENT => ['onCartChangedEvent', 0],
            KernelEvents::CONTROLLER                    => ['onKernelController', 0],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $this->cartManager->initializeCart();
    }

    public function onCartChangedEvent(CartEvent $cartEvent)
    {
        $cart       = $cartEvent->getCart();
        $products   = $cart->getProducts();
        $cartTotals = $cart->getTotals();

        $products->map(function (CartProductInterface $cartProduct) use ($cartTotals) {
        });
    }
}
