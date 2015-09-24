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
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\OrderBundle\Entity\Order;

/**
 * Class OrderFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderFactory extends AbstractFactory implements OrderFactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\OrderBundle\Entity\OrderInterface
     */
    public function create()
    {
        $order = new Order();
        $order->setModifiers(new ArrayCollection());
        $order->setProducts(new ArrayCollection());
        $order->setPayments(new ArrayCollection());

        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function createOrderFromCart(CartInterface $cart)
    {
        $order = $this->create();
        $order->setPaymentMethod($cart->getPaymentMethod());
        $order->setShippingMethod($cart->getShippingMethodCost()->getShippingMethod());
        $order->setBillingAddress($cart->getBillingAddress());
        $order->setShippingAddress($cart->getShippingAddress());
        $order->setShop($cart->getShop());
        $order->setSessionId($cart->getSessionId());
        $order->setClient($cart->getClient());
        $order->setCurrency($cart->getCurrency());
        $order->setCurrentStatus($cart->getShop()->getDefaultOrderStatus());

        return $order;
    }
}
