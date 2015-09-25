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
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductTotals;
use WellCommerce\Bundle\OrderBundle\Entity\OrderShippingDetails;
use WellCommerce\Bundle\OrderBundle\Factory\OrderProductFactoryInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;

/**
 * Class OrderConfirmationManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderConfirmationManager extends AbstractFrontManager
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

        $this->prepareOrderProductTotals($order, $cart);
        $this->prepareShippingDetails($order, $cart->getShippingMethodCost());
        $this->prepareOrderProducts($cart, $order);

        return $order;
    }

    /**
     * Prepares order product totals
     *
     * @param OrderInterface $order
     * @param CartInterface  $cart
     */
    protected function prepareOrderProductTotals(OrderInterface $order, CartInterface $cart)
    {
        $cartTotals         = $cart->getTotals();
        $orderProductTotals = new OrderProductTotals();

        $orderProductTotals->setGrossAmount($cartTotals->getGrossPrice());
        $orderProductTotals->setNetAmount($cartTotals->getNetPrice());
        $orderProductTotals->setTaxAmount($cartTotals->getTaxAmount());
        $orderProductTotals->setQuantity($cartTotals->getQuantity());
        $orderProductTotals->setWeight($cartTotals->getWeight());

        $order->setProductTotals($orderProductTotals);
    }

    /**
     * Prepares order shipping details
     *
     * @param OrderInterface              $order
     * @param ShippingMethodCostInterface $shippingMethodCost
     */
    protected function prepareShippingDetails(OrderInterface $order, ShippingMethodCostInterface $shippingMethodCost)
    {
        $cost         = $shippingMethodCost->getCost();
        $baseCurrency = $cost->getCurrency();
        $grossAmount  = $this->getCurrencyHelper()->convert($cost->getGrossAmount(), $baseCurrency, $order->getCurrency());
        $netAmount    = $this->getCurrencyHelper()->convert($cost->getNetAmount(), $baseCurrency, $order->getCurrency());
        $taxAmount    = $this->getCurrencyHelper()->convert($cost->getTaxAmount(), $baseCurrency, $order->getCurrency());

        $shippingDetails = new OrderShippingDetails();
        $shippingDetails->setGrossPrice($grossAmount);
        $shippingDetails->setNetPrice($netAmount);
        $shippingDetails->setTaxAmount($taxAmount);
        $shippingDetails->setTaxRate($cost->getTaxRate());

        $order->setShippingDetails($shippingDetails);
    }

    /**
     * @param OrderInterface $order
     */
    public function saveOrder(OrderInterface $order)
    {
        $this->createResource($order);
        $this->cartManager->abandonCart($this->getCurrentCart());

        $this->getRequestHelper()->setSessionAttribute('orderId', $order->getId());
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
