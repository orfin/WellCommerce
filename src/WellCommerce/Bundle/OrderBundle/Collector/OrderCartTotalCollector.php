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
 * Class OrderCartTotalCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderCartTotalCollector extends AbstractDataCollector
{
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        $orderProductTotal  = $order->getProductTotal();
        $orderProductDetail = $this->initResource();

        $orderProductDetail->setOrderTotal($orderProductTotal);
        $orderProductDetail->setOrder($order);

        $order->addTotal($orderProductDetail);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'cart_total';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }
}
