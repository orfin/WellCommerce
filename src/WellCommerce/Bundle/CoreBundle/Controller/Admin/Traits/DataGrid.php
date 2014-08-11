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

namespace WellCommerce\Bundle\CoreBundle\Controller\Admin\Traits;

use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class DataGrid
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller\Admin\Traits
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait DataGrid
{
    private $dataGrid;

    public function setDataGrid(DataGridInterface $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }

    public function buildDataGrid()
    {
        return $this->getDataGrid($this->dataGrid);
    }
} 