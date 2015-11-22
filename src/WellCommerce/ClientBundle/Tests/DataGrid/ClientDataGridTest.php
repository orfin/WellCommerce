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

namespace WellCommerce\ClientBundle\Tests\DataGrid;

use WellCommerce\AppBundle\Test\DataGrid\AbstractDataGridTestCase;

/**
 * Class ClientDataGridTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataGridTest extends AbstractDataGridTestCase
{
    protected function getDataGrid()
    {
        return $this->container->get('client.datagrid')->getInstance();
    }

    protected function getColumns()
    {
        return [
            'id',
            'firstName',
            'lastName',
            'email',
            'phone',
            'groupName',
            'createdAt',
        ];
    }
}
