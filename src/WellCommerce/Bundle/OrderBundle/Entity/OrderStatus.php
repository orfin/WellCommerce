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

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * OrderStatus
 *
 * @ORM\Table(name="order_status")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\OrderBundle\Repository\OrderStatusRepository")
 */
class OrderStatus
{
    use Timestampable;
    use Blameable;
    use Translatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\OrderBundle\Entity\OrderStatusGroup")
     * @ORM\JoinColumn(name="order_status_group_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $orderStatusGroup;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return OrderStatusGroup
     */
    public function getOrderStatusGroup()
    {
        return $this->orderStatusGroup;
    }

    /**
     * @param OrderStatusGroup $orderStatusGroup
     */
    public function setOrderStatusGroup(OrderStatusGroup $orderStatusGroup)
    {
        $this->orderStatusGroup = $orderStatusGroup;
    }
}
