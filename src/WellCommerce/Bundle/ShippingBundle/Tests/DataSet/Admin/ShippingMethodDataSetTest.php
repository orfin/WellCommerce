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

namespace WellCommerce\Bundle\ShippingBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class ShippingMethodDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('shipping_method.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'         => 'shipping_method.id',
            'name'       => 'shipping_method_translation.name',
            'calculator' => 'shipping_method.calculator',
            'hierarchy'  => 'shipping_method.hierarchy',
        ];
    }
}
