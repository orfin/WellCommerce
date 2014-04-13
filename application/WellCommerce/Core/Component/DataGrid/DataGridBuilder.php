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

namespace WellCommerce\Core\Component\DataGrid;

use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class DataGridBuilder
 *
 * @package WellCommerce\Core\Component\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridBuilder extends AbstractComponent
{
    const DATAGRID_INIT = 'datagrid.init';

    protected $datagrid;
    protected $options;

    /**
     * Creates datagrid and triggers event after initialization
     *
     * @param DataGridInterface $datagrid DataGrid instance
     * @param array             $options  DataGrid options
     *
     * @return $this
     */
    public function create(DataGridInterface $datagrid, array $options)
    {
        $this->datagrid = $datagrid->buildDataGrid();
        $this->options  = $options;
        $this->datagrid = $this->dispatchEvent($this->getInitEventName());

        return $this;
    }

    /**
     * Dispatches the event for form action
     *
     * @param       $eventName
     * @param array $data
     * @param       $id
     */
    final protected function dispatchEvent($eventName)
    {
        $event = new DataGridEvent($this->datagrid, $this->options);
        $this->getDispatcher()->dispatch($eventName, $event);
        $this->datagrid->setOptions($event->getOptions());

        return $event->getDataGrid();
    }

    /**
     * Returns init event name
     *
     * @return string
     */
    private function getInitEventName()
    {
        return sprintf('%s.%s', $this->options['id'], self::DATAGRID_INIT);
    }

    /**
     * Returns DataGrid object
     *
     * @return mixed
     */
    public function getDataGrid()
    {
        return $this->datagrid;
    }
}