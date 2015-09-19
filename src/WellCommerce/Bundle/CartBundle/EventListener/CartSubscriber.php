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
use WellCommerce\Bundle\CartBundle\Calculator\CartTotalsCalculatorInterface;
use WellCommerce\Bundle\CartBundle\Event\CartEvent;
use WellCommerce\Bundle\CartBundle\EventDispatcher\CartEventDispatcher;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartManagerInterface;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

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
     * @var CartTotalsCalculatorInterface
     */
    protected $cartTotalsCalculator;

    /**
     * Constructor
     *
     * @param CartManagerInterface $cartManager
     */
    public function __construct(CartManagerInterface $cartManager, CartTotalsCalculatorInterface $cartTotalsCalculator)
    {
        $this->cartManager          = $cartManager;
        $this->cartTotalsCalculator = $cartTotalsCalculator;
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
        $this->cartTotalsCalculator->calculate($cartEvent->getCart());
    }
}
