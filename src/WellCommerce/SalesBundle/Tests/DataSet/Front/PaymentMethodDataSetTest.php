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

namespace WellCommerce\SalesBundle\Tests\DataSet\Front;

use WellCommerce\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class PaymentMethodDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('payment_method.dataset.front');
    }

    protected function getColumns()
    {
        return [
            'id'        => 'payment_method.id',
            'name'      => 'payment_method_translation.name',
            'processor' => 'payment_method.processor'
        ];
    }
}
