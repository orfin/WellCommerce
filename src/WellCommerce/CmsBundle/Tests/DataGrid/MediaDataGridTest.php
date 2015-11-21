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

use WellCommerce\CoreBundle\Test\DataGrid\AbstractDataGridTestCase;

/**
 * Class MediaDataGridTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaDataGridTest extends AbstractDataGridTestCase
{
    protected function get()
    {
        return $this->container->get('media.datagrid')->getInstance();
    }

    protected function getColumns()
    {
        return ['id', 'name', 'preview', 'mime', 'extension', 'size'];
    }
}
