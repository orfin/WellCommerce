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

namespace WellCommerce\Bundle\AppBundle\Tests\DataGrid;

use WellCommerce\Bundle\CoreBundle\Test\DataGrid\AbstractDataGridTestCase;

/**
 * Class ClientGroupDataGridTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupDataGridTest extends AbstractDataGridTestCase
{
    protected function getDataGrid()
    {
        return $this->container->get('client_group.datagrid')->getInstance();
    }

    protected function getColumns()
    {
        return [
            'id',
            'name',
            'totalClients',
        ];
    }
}
