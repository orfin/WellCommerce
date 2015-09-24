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

namespace WellCommerce\Bundle\OrderBundle\Manager\Front;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartManagerInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Factory\OrderProductFactoryInterface;

/**
 * Class OrderManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderManager extends AbstractFrontManager
{
    /**
     * @var \WellCommerce\Bundle\OrderBundle\Factory\OrderFactoryInterface
     */
    protected $factory;

    /**
     * @var OrderProductFactoryInterface
     */
    protected $orderProductFactory;

    /**
     * @var CartManagerInterface
     */
    protected $cartManager;

    /**
     * @param OrderProductFactoryInterface $orderProductFactory
     */
    public function setOrderProductFactory(OrderProductFactoryInterface $orderProductFactory)
    {
        $this->orderProductFactory = $orderProductFactory;
    }

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
        $this->prepareOrderProducts($cart, $order);

        return $order;
    }

    /**
     * @param OrderInterface $order
     */
    public function saveOrder(OrderInterface $order)
    {
        $this->createResource($order);
        $this->cartManager->abandonCart($this->getCurrentCart());
    }

    /**
     * Adds all products to order
     *
     * @param CartInterface  $cart
     * @param OrderInterface $order
     */
    protected function prepareOrderProducts(CartInterface $cart, OrderInterface $order)
    {
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use ($order) {
            $orderProduct = $this->orderProductFactory->createFromCartProduct($cartProduct);
            $orderProduct->setOrder($order);
            $order->addProduct($orderProduct);
        });
    }
}
