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

namespace WellCommerce\Bundle\AvailabilityBundle\Tests\DataGrid;

use WellCommerce\Bundle\CoreBundle\Tests\DataGridTestCase;

/**
 * Class AvailabilityDataGridTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDataGridTest extends DataGridTestCase
{
    /**
     * @return \WellCommerce\Bundle\DataGridBundle\DataGridInterface
     */
    protected function getDataGridInstance()
    {
        return $this->container->get('availability.datagrid')->getInstance();
    }

    protected function getRequiredColumns()
    {
        return ['id', 'name'];
    }
}
