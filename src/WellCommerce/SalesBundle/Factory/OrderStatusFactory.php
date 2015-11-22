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

namespace WellCommerce\SalesBundle\Factory;

use WellCommerce\AppBundle\Factory\AbstractFactory;
use WellCommerce\SalesBundle\Entity\OrderStatus;

/**
 * Class OrderStatusFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\SalesBundle\Entity\OrderStatusInterface
     */
    public function create()
    {
        $status = new OrderStatus();
        $status->setEnabled(true);

        return $status;
    }
}
