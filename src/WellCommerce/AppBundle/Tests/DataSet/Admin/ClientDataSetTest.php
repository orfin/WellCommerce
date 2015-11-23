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

namespace WellCommerce\AppBundle\Tests\DataSet\Admin;

use WellCommerce\AppBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class ClientDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('client.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'        => 'client.id',
            'firstName' => 'client.contactDetails.firstName',
            'lastName'  => 'client.contactDetails.lastName',
            'email'     => 'client.contactDetails.email',
            'phone'     => 'client.contactDetails.phone',
            'groupName' => 'client_group_translation.name',
            'createdAt' => 'client.createdAt',
        ];
    }
}
