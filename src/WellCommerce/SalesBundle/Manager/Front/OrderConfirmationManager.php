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

use WellCommerce\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\SalesBundle\Entity\CartInterface;
use WellCommerce\SalesBundle\Entity\OrderInterface;

/**
 * Class OrderConfirmationManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderConfirmationManager extends AbstractFrontManager
{
    /**
     * @var \WellCommerce\SalesBundle\Factory\OrderFactoryInterface
     */
    protected $factory;

    /**
     * @var \WellCommerce\SalesBundle\EventDispatcher\OrderEventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var CartManagerInterface
     */
    protected $cartManager;

    /**
     * @param CartManagerInterface $cartManager
     */
    public function setCartManager(CartManagerInterface $cartManager)
    {
        $this->cartManager = $cartManager;
    }

    /**
     * Prepares the order
     *
     * @param CartInterface $cart
     *
     * @return OrderInterface
     */
    public function prepareOrder(CartInterface $cart)
    {
        $order = $this->factory->createOrderFromCart($cart);

        $this->eventDispatcher->dispatchOnPostOrderPrepared($order);

        return $order;
    }

    /**
     * @param OrderInterface $order
     */
    public function saveOrder(OrderInterface $order)
    {
        $this->createResource($order);
        $cart = $this->getCartContext()->getCurrentCart();
        $this->cartManager->abandonCart($cart);

        $this->getRequestHelper()->setSessionAttribute('orderId', $order->getId());
    }
}
