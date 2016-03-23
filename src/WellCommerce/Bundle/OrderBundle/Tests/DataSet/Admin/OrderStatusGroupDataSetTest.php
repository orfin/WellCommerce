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

namespace WellCommerce\Bundle\OrderBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class OrderStatusGroupGroupDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusGroupDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('order_status_group.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'        => 'order_status_group.id',
            'name'      => 'order_status_group_translation.name',
            'createdAt' => 'order_status_group.createdAt',
        ];
    }
}
