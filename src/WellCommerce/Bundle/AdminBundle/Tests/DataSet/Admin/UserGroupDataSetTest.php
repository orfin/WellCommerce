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

namespace WellCommerce\Bundle\AdminBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class UserGroupDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroupDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('user_group.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'   => 'user_group.id',
            'name' => 'user_group.name',
        ];
    }
}
