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

namespace WellCommerce\Bundle\ShopBundle\Tests\DataGrid;

use WellCommerce\Bundle\CoreBundle\Test\DataGrid\AbstractDataGridTestCase;

/**
 * Class ShopDataGridTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopDataGridTest extends AbstractDataGridTestCase
{
    protected function get()
    {
        return $this->container->get('shop.datagrid')->getInstance();
    }

    protected function getColumns()
    {
        return ['id', 'name', 'url', 'company', 'theme', 'country', 'currency'];
    }
}
