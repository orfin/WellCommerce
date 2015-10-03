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

namespace WellCommerce\Bundle\OrderBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\IntlBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\Order;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotal;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;

/**
 * Class OrderFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderFactory extends AbstractFactory implements OrderFactoryInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    protected $currencyHelper;

    /**
     * @var OrderProductFactoryInterface
     */
    protected $orderProductFactory;

    /**
     * Constructor
     *
     * @param CurrencyHelperInterface      $currencyHelper
     * @param OrderProductFactoryInterface $orderProductFactory
     */
    public function __construct(CurrencyHelperInterface $currencyHelper, OrderProductFactoryInterface $orderProductFactory)
    {
        $this->currencyHelper      = $currencyHelper;
        $this->orderProductFactory = $orderProductFactory;
    }

    /**
     * @return \WellCommerce\Bundle\OrderBundle\Entity\OrderInterface
     */
    public function create()
    {
        $order = new Order();
        $order->setProducts(new ArrayCollection());
        $order->setPayments(new ArrayCollection());
        $order->setTotals(new ArrayCollection());

        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function createOrderFromCart(CartInterface $cart)
    {
        $order = $this->create();
        $order->setCurrency($cart->getCurrency());
        $order->setPaymentMethod($cart->getPaymentMethod());
        $order->setShippingMethod($cart->getShippingMethodCost()->getShippingMethod());
        $order->setBillingAddress($cart->getBillingAddress());
        $order->setShippingAddress($cart->getShippingAddress());
        $order->setContactDetails($cart->getContactDetails());
        $order->setShop($cart->getShop());
        $order->setSessionId($cart->getSessionId());
        $order->setClient($cart->getClient());
        $order->setCurrentStatus($cart->getPaymentMethod()->getDefaultOrderStatus());
        $order->setCoupon($cart->getCoupon());

        $this->prepareOrderProducts($cart, $order);
        $this->prepareShippingTotals($order, $cart->getShippingMethodCost());
        $this->prepareProductTotals($order, $cart);

        return $order;
    }

    /**
     * Prepares order product totals
     *
     * @param OrderInterface              $order
     * @param ShippingMethodCostInterface $shippingMethodCost
     */
    protected function prepareProductTotals(OrderInterface $order, CartInterface $cart)
    {
        $cartTotals   = $cart->getTotals();
        $baseCurrency = $cart->getCurrency();
        $productTotal = new OrderTotal();
        $productTotal->setGrossAmount($this->currencyHelper->convert($cartTotals->getGrossPrice(), $baseCurrency, $order->getCurrency()));
        $productTotal->setNetAmount($this->currencyHelper->convert($cartTotals->getNetPrice(), $baseCurrency, $order->getCurrency()));
        $productTotal->setTaxAmount($this->currencyHelper->convert($cartTotals->getTaxAmount(), $baseCurrency, $order->getCurrency()));
        $productTotal->setCurrency($order->getCurrency());

        $order->setProductTotal($productTotal);
    }

    /**
     * Prepares order shipping details
     *
     * @param OrderInterface              $order
     * @param ShippingMethodCostInterface $shippingMethodCost
     */
    protected function prepareShippingTotals(OrderInterface $order, ShippingMethodCostInterface $shippingMethodCost)
    {
        $cost          = $shippingMethodCost->getCost();
        $baseCurrency  = $cost->getCurrency();
        $shippingTotal = new OrderTotal();
        $shippingTotal->setGrossAmount($this->currencyHelper->convert($cost->getGrossAmount(), $baseCurrency, $order->getCurrency()));
        $shippingTotal->setNetAmount($this->currencyHelper->convert($cost->getNetAmount(), $baseCurrency, $order->getCurrency()));
        $shippingTotal->setTaxAmount($this->currencyHelper->convert($cost->getTaxAmount(), $baseCurrency, $order->getCurrency()));
        $shippingTotal->setTaxRate($this->currencyHelper->convert($cost->getTaxRate()));
        $shippingTotal->setCurrency($order->getCurrency());

        $order->setShippingTotal($shippingTotal);
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
