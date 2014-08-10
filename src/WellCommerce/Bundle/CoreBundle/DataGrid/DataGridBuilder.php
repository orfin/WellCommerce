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

namespace WellCommerce\Bundle\CoreBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Event\DataGridEvent;

/**
 * Class DataGridBuilder
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridBuilder extends AbstractContainer
{
    /**
     * Creates datagrid and triggers event after initialization
     *
     * @param DataGridInterface $datagrid
     *
     * @return DataGridInterface
     */
    public function create(DataGridInterface $datagrid)
    {
        $datagrid->addColumns();

        $eventName = $this->getInitEventName($datagrid->getIdentifier());
        $event     = new DataGridEvent($datagrid);
        $this->getDispatcher()->dispatch($eventName, $event);

        return $event->getDataGrid();
    }

    /**
     * Returns init event name
     *
     * @return string
     */
    private function getInitEventName($identifier)
    {
        return sprintf('%s.%s', $identifier, DataGridInterface::DATAGRID_INIT_EVENT);
    }
}