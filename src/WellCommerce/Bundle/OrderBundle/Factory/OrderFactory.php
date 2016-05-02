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
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductTotalInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderSummaryInterface;

/**
 * Class OrderFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = OrderInterface::class;
    
    /**
     * @return OrderInterface
     */
    public function create() : OrderInterface
    {
        /** @var  $order OrderInterface */
        $order = $this->init();
        $order->setConfirmed(false);
        $order->setProducts($this->createEmptyCollection());
        $order->setProductTotal($this->createOrderProductTotal());
        $order->setModifiers($this->createEmptyCollection());
        $order->setPayments(new ArrayCollection());
        $order->setOrderStatusHistory(new ArrayCollection());
        $order->setComment('');
        $order->setCurrency($this->getRequestHelper()->getCurrentCurrency());
        $order->setSessionId($this->getRequestHelper()->getSessionId());
        $order->setSummary($this->createOrderSummary());
        $order->setContactDetails($this->createContactDetails());
        $order->setBillingAddress($this->createBillingAddress());
        $order->setShippingAddress($this->createShippingAddress());
        
        return $order;
    }
    
    private function createContactDetails() : ClientContactDetailsInterface
    {
        return $this->get('client_contact_details.factory')->create();
    }
    
    private function createBillingAddress() : ClientBillingAddressInterface
    {
        return $this->get('client_billing_address.factory')->create();
    }
    
    private function createShippingAddress() : ClientShippingAddressInterface
    {
        return $this->get('client_shipping_address.factory')->create();
    }
    
    private function createOrderProductTotal() : OrderProductTotalInterface
    {
        return $this->get('order_product_total.factory')->create();
    }
    
    private function createOrderSummary() : OrderSummaryInterface
    {
        return $this->get('order_summary.factory')->create();
    }
    
}
