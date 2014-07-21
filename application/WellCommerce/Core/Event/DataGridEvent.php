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

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class DataGridEvent
 *
 * @package WellCommerce\Core\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridEvent extends Event
{
    /**
     * @var \WellCommerce\Core\DataGrid\DataGridInterface
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
     * @return mixed
     */
    public function getDataGrid()
    {
        return $this->datagrid;
    }
}