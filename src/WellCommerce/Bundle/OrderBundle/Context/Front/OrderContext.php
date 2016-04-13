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

namespace WellCommerce\Bundle\OrderBundle\Context\Front;

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Class OrderContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderContext implements OrderContextInterface
{
    /**
     * @var OrderInterface
     */
    protected $currentOrder;

    /**
     * {@inheritdoc}
     */
    public function setCurrentOrder(OrderInterface $order)
    {
        $this->currentOrder = $order;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentOrder() : OrderInterface
    {
        return $this->currentOrder;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentOrder() : bool
    {
        return $this->currentOrder instanceof OrderInterface;
    }
}
