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

namespace WellCommerce\Bundle\ProducerBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class ProducerDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('producer.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'    => 'producer.id',
            'name'  => 'producer_translation.name',
            'shop'  => 'producer_shops.id',
            'route' => 'IDENTITY(producer_translation.route)',
        ];
    }
}
