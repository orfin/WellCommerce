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

namespace WellCommerce\Bundle\OrderBundle\Collector;

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Class OrderShippingCostCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderShippingCostCollector extends AbstractDataCollector
{
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        $orderTotalDetail = $this->initResource();
        $shippingTotal    = $order->getShippingTotal();
        
        $orderTotalDetail->setOrderTotal($shippingTotal);
        $orderTotalDetail->setOrder($order);
        
        $order->addTotal($orderTotalDetail);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'shipping_cost';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'order.label.shipping_cost_description';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 100;
    }
}
