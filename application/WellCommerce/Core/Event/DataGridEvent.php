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
namespace WellCommerce\Core\Event;

use WellCommerce\Core\DataGrid;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class DataGridEvent
 *
 * @package WellCommerce\Core\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridEvent extends Event
{

    protected $datagrid;

    /**
     * Constructor
     *
     * @param DataGrid $datagrid
     */
    public function __construct(DataGrid $datagrid)
    {
        $this->datagrid = $datagrid;
    }

    /**
     * Returns DataGrid
     *
     * @return mixed
     */
    public function getDataGrid()
    {
        return $this->datagrid;
    }
}