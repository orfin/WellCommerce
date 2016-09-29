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

use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface OrderStatusHistoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderStatusHistoryInterface extends EntityInterface, OrderAwareInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return OrderStatusInterface
     */
    public function getOrderStatus();
    
    /**
     * @param OrderStatusInterface $orderStatus
     */
    public function setOrderStatus(OrderStatusInterface $orderStatus = null);
    
    /**
     * @return string
     */
    public function getComment() : string;
    
    /**
     * @param string $comment
     */
    public function setComment(string $comment);
    
    /**
     * @return bool
     */
    public function isNotify() : bool;
    
    /**
     * @param bool $notify
     */
    public function setNotify(bool $notify);
}
