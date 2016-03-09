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

namespace WellCommerce\Bundle\LayoutBundle\Tests\DataGrid;

use WellCommerce\Bundle\CoreBundle\Test\DataGrid\AbstractDataGridTestCase;

/**
 * Class LayoutBoxDataGridTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxDataGridTest extends AbstractDataGridTestCase
{
    protected function get()
    {
        return $this->container->get('layout_box.datagrid')->getInstance();
    }

    protected function getColumns()
    {
        return ['id', 'name', 'identifier', 'boxType'];
    }
}
