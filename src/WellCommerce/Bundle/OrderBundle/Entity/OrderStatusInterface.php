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

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface OrderStatusInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderStatusInterface extends
    EntityInterface,
    EnableableInterface,
    TimestampableInterface,
    TranslatableInterface,
    BlameableInterface
{
    /**
     * @return OrderStatusGroupInterface
     */
    public function getOrderStatusGroup() : OrderStatusGroupInterface;
    
    /**
     * @param OrderStatusGroupInterface $orderStatusGroup
     */
    public function setOrderStatusGroup(OrderStatusGroupInterface $orderStatusGroup);
}
