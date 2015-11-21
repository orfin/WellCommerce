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

namespace WellCommerce\SalesBundle\Tests\DataSet\Admin;

use WellCommerce\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class OrderDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('order.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'            => 'orders.id',
            'client'        => 'CONCAT_WS(\':\', orders.billingAddress.firstName, orders.billingAddress.lastName, orders.contactDetails.phone)',
            'productTotal'  => 'orders.productTotal.grossAmount',
            'shippingTotal' => 'orders.shippingTotal.grossAmount',
            'orderTotal'    => 'orders.orderTotal.grossAmount',
            'currentStatus' => 'status_translation.name',
            'currency'      => 'orders.currency',
            'createdAt'     => 'orders.createdAt',
        ];
    }
}
