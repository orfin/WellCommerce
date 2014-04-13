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
use WellCommerce\Core\Component\DataGrid\DataGridInterface;

/**
 * Class DataGridEvent
 *
 * @package WellCommerce\Core\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridEvent extends Event
{

    protected $datagrid;
    protected $options;

    /**
     * Constructor
     *
     * @param DataGridInterface $datagrid
     */
    public function __construct(DataGridInterface $datagrid, array $options)
    {
        $this->datagrid = $datagrid;
        $this->options  = $options;
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

    /**
     * Returns DataGrid options
     *
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets DataGrid options
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }
}