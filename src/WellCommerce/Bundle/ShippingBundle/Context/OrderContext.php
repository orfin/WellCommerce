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

namespace WellCommerce\Bundle\ShippingBundle\Context;

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingSubjectInterface;

/**
 * Class OrderAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderContext implements ShippingSubjectInterface
{
    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * OrderAdapter constructor.
     *
     * @param OrderInterface $order
     */
    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    public function getQuantity() : int
    {
        return $this->order->getProductTotal()->getQuantity();
    }
    
    public function getWeight() : float
    {
        return $this->order->getProductTotal()->getWeight();
    }
    
    public function getGrossPrice() : float
    {
        return $this->order->getProductTotal()->getGrossPrice();
    }

    public function getNetPrice() : float
    {
        return $this->order->getProductTotal()->getNetPrice();
    }

    public function getTaxAmount() : float
    {
        return $this->order->getProductTotal()->getTaxAmount();
    }

    public function getCurrency() : string
    {
        return $this->order->getCurrency();
    }
}
