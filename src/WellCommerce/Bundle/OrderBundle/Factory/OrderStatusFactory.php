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
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatus;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;

/**
 * Class OrderStatusFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusFactory extends AbstractEntityFactory
{
    public function create() : OrderStatusInterface
    {
        $status = new OrderStatus();
        $status->setEnabled(true);
        
        return $status;
    }
}
