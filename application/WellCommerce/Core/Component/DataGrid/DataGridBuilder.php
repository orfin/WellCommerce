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
    const DATAGRID_INIT_EVENT = 'datagrid.init';

    protected $datagrid;
    protected $options;

    /**
     * Creates datagrid and triggers event after initialization
     *
     * @param DataGridInterface $datagrid
     *
     * @return $this
     */
    public function create(DataGridInterface $datagrid)
    {
        $this->datagrid = $datagrid;
        $this->datagrid->initColumns();
        $this->datagrid->setQuery();
        $this->dispatchEvent($this->getInitEventName());

        return $this->datagrid;
    }

    /**
     * Triggers the event for form action
     *
     * @param       $eventName
     * @param array $data
     * @param       $id
     */
    private function dispatchEvent($eventName)
    {
        $event = new DataGridEvent($this->datagrid);
        $this->getDispatcher()->dispatch($eventName, $event);
        $this->datagrid = $event->getDataGrid();
    }

    /**
     * Returns init event name
     *
     * @return string
     */
    private function getInitEventName()
    {
        return sprintf('%s.%s', $this->datagrid->getId(), self::DATAGRID_INIT_EVENT);
    }
}