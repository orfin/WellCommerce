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

namespace WellCommerce\Core\DataGrid;

use Illuminate\Database\Capsule\Manager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Core\AbstractComponent;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Configuration\OptionInterface;
use WellCommerce\Core\DataGrid\Loader\LoaderInterface;
use WellCommerce\Core\DataGrid\Options\OptionsInterface;
use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class DataGridBuilder
 *
 * @package WellCommerce\Core\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridBuilder extends AbstractComponent
{
    /**
     * @var DataGridInterface DataGrid instance
     */
    private $datagrid;

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
        $this->datagrid->addColumns();

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
        return sprintf('%s.%s', $this->datagrid->getIdentifier(), DataGridInterface::DATAGRID_INIT_EVENT);
    }
}