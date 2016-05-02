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

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusGroupInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;

/**
 * Class OrderStatusFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = OrderStatusInterface::class;
    
    /**
     * @return OrderStatusInterface
     */
    public function create() : OrderStatusInterface
    {
        /** @var  $status OrderStatusInterface */
        $status = $this->init();
        $status->setEnabled(true);
        $status->setOrderStatusGroup($this->getDefaultOrderStatusGroup());
        
        return $status;
    }
    
    private function getDefaultOrderStatusGroup() : OrderStatusGroupInterface
    {
        return $this->get('order_status_group.repository')->findOneBy([]);
    }
}
