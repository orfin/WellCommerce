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
 * Class OrderPaymentSurchargeCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderPaymentSurchargeCollector implements OrderDataCollectorInterface
{
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'payment_surcharge';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'order.label.payment_surcharge_description';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 200;
    }
}
