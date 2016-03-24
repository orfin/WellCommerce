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
namespace WellCommerce\Component\DataGrid\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Component\DataGrid\DataGridInterface;

/**
 * Class DataGridEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridEvent extends Event
{
    /**
     * @var DataGridInterface
     */
    protected $datagrid;
    
    /**
     * Constructor
     *
     * @param DataGridInterface $datagrid
     */
    public function __construct(DataGridInterface $datagrid)
    {
        $this->datagrid = $datagrid;
    }

    /**
     * Returns DataGrid
     *
     * @return DataGridInterface
     */
    public function getDataGrid() : DataGridInterface
    {
        return $this->datagrid;
    }
}
