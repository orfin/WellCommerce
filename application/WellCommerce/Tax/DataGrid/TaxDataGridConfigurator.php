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

namespace WellCommerce\Tax\DataGrid;

use WellCommerce\Core\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\EditRowEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\UpdateRowEventHandler;
use WellCommerce\Core\DataGrid\Configuration\Filter\Filter;
use WellCommerce\Core\DataGrid\Configuration\OptionInterface;
use WellCommerce\Core\DataGrid\Configurator\AbstractConfigurator;
use WellCommerce\Core\DataGrid\Configurator\ConfiguratorInterface;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class TaxDataGridConfigurator
 *
 * @package WellCommerce\Tax\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxDataGridConfigurator extends AbstractConfigurator implements ConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(DataGridInterface $datagrid)
    {
        $datagrid->setIdentifier($this->identifier);

        $datagrid->setColumns($this->columns);

        $datagrid->setQueryBuilder($this->queryBuilder);

        $eventHandlers = $this->options->getEventHandlers();

        $eventHandlers->add(new LoadEventHandler([
            'function' => $this->getXajaxManager()->register([$this->getFunction('load'), $datagrid, 'load']),
        ]));

        $eventHandlers->add(new EditRowEventHandler([
            'function'   => $function = $this->getFunction('edit'),
            'callback'   => $function,
            'row_action' => OptionInterface::ACTION_EDIT,
            'route'      => $this->generateUrl('admin.tax.edit')
        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $function = $this->getFunction('delete'),
            'callback'   => $this->getXajaxManager()->register([$function, $datagrid, 'delete']),
            'row_action' => OptionInterface::ACTION_DELETE,
        ]));

        $datagrid->setOptions($this->options);
    }
}