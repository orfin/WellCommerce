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

use Illuminate\Database\Capsule\Manager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\Component\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\Component\DataGrid\Configuration\Options;
use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class DataGridBuilder
 *
 * @package WellCommerce\Core\Component\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridBuilder extends AbstractComponent
{
    protected $datagrid;
    protected $manager;
    protected $options;
    protected $columns;

    /**
     * Sets Database Manager instance on class
     *
     * @param Manager $manager
     */
    public function setDatabaseManager(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Creates datagrid and triggers event after initialization
     *
     * @param DataGridInterface $datagrid
     *
     * @return $this
     */
    public function create(DataGridInterface $datagrid)
    {
        $this->options  = new Options();
        $this->columns  = new ColumnCollection();
        $this->datagrid = $datagrid;
        $this->datagrid->configure($this->options);
        $this->datagrid->build($this->columns);

        die();

        $columnCollection = new ColumnCollection();
        $this->datagrid->initColumns($columnCollection);
        $this->datagrid->setColumns($columnCollection);
        $this->datagrid->setQuery($this->manager);
        $this->dispatchEvent($this->getInitEventName());

        return $this->datagrid;
    }

    public function addColumn(ColumnInterface $column)
    {
        $this->columns->add($column);
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
        return sprintf('%s.%s', $this->datagrid->getId(), DataGridInterface::DATAGRID_INIT_EVENT);
    }
}