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
 * Class UserDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('user.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'         => 'user.id',
            'username'   => 'user.username',
            'name'       => 'CONCAT(user.firstName,\' \', user.lastName)',
            'first_name' => 'user.firstName',
            'last_name'  => 'user.lastName',
            'email'      => 'user.email',
            'enabled'    => 'user.enabled',
        ];
    }
}
