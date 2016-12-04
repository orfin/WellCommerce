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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class OrderStatus
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusHistory implements OrderStatusHistoryInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use Blameable;
    use OrderAwareTrait;
    
    protected $comment = '';
    protected $notify  = false;
    
    /**
     * @var OrderStatusInterface
     */
    protected $orderStatus;
    
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }
    
    public function setOrderStatus(OrderStatusInterface $orderStatus = null)
    {
        $this->orderStatus = $orderStatus;
        $this->getOrder()->setCurrentStatus($orderStatus);
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    public function isNotify(): bool
    {
        return $this->notify;
    }

    public function setNotify(bool $notify)
    {
        $this->notify = $notify;
    }
}
