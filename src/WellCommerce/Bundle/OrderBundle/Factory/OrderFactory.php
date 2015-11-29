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

namespace WellCommerce\Bundle\AppBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AppBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\AppBundle\Entity\CartInterface;
use WellCommerce\Bundle\AppBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\AppBundle\Entity\Order;
use WellCommerce\Bundle\AppBundle\Entity\OrderInterface;

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
     * @var OrderTotalFactory
     */
    protected $orderTotalFactory;

    /**
     * OrderFactory constructor.
     *
     * @param OrderProductFactoryInterface $orderProductFactory
     * @param OrderTotalFactory            $orderTotalFactory
     * @param CurrencyHelperInterface      $currencyHelper
     */
    public function __construct(
        OrderProductFactoryInterface $orderProductFactory,
        OrderTotalFactory $orderTotalFactory,
        CurrencyHelperInterface $currencyHelper
    ) {
        $this->orderProductFactory = $orderProductFactory;
        $this->orderTotalFactory   = $orderTotalFactory;
        $this->currencyHelper      = $currencyHelper;
    }

    /**
     * @return \WellCommerce\Bundle\AppBundle\Entity\OrderInterface
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
        $this->prepareOrderShippingDetails($cart, $order);

        return $order;
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
            $orderProduct = $this->orderProductFactory->createFromCartProduct($cartProduct, $order);
            $orderProduct->setOrder($order);
            $order->addProduct($orderProduct);
        });
    }

    protected function prepareOrderShippingDetails(CartInterface $cart, OrderInterface $order)
    {
        $cost        = $cart->getShippingMethodCost()->getCost();
        $grossAmount = $this->currencyHelper->convert($cost->getGrossAmount(), $cost->getCurrency(), $order->getCurrency());
        $taxRate     = $cost->getTaxRate();
        $orderTotal  = $this->orderTotalFactory->createFromSpecifiedValues($grossAmount, $taxRate, $order->getCurrency());

        $order->setShippingTotal($orderTotal);
    }
}
