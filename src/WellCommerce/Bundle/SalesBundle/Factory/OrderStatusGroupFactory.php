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

namespace WellCommerce\Bundle\SalesBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\SalesBundle\Entity\OrderStatusGroup;

/**
 * Class OrderStatusGroupFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusGroupFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\SalesBundle\Entity\OrderStatusGroupInterface
     */
    public function create()
    {
        $group = new OrderStatusGroup();

        return $group;
    }
}
