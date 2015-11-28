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

namespace WellCommerce\Bundle\AppBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class ClientGroupDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('client_group.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'           => 'client_group.id',
            'name'         => 'client_group_translation.name',
            'totalClients' => 'COUNT(client)',
        ];
    }
}
