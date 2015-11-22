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

namespace WellCommerce\CmsBundle\Tests\DataGrid;

use WellCommerce\AppBundle\Test\DataGrid\AbstractDataGridTestCase;

/**
 * Class NewsDataGridTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsDataGridTest extends AbstractDataGridTestCase
{
    protected function get()
    {
        return $this->container->get('news.datagrid')->getInstance();
    }

    protected function getColumns()
    {
        return ['id', 'name'];
    }
}
