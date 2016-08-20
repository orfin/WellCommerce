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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusGroup;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusGroupInterface;

/**
 * Class OrderStatusGroupFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusGroupFactory extends AbstractEntityFactory
{
    public function create() : OrderStatusGroupInterface
    {
        $group = new OrderStatusGroup();
        
        return $group;
    }
}
