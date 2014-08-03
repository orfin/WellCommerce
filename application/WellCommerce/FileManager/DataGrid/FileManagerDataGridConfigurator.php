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

namespace WellCommerce\FileManager\DataGrid;

use Symfony\Component\Process\Process;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\LoadedEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\ProcessEventHandler;
use WellCommerce\Core\DataGrid\Configuration\OptionInterface;
use WellCommerce\Core\DataGrid\Configurator\AbstractConfigurator;
use WellCommerce\Core\DataGrid\Configurator\ConfiguratorInterface;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class FileManagerDataGridConfigurator
 *
 * @package WellCommerce\File\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileManagerDataGridConfigurator extends AbstractConfigurator implements ConfiguratorInterface
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

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $function = $this->getFunction('delete'),
            'callback'   => $this->getXajaxManager()->register([$function, $datagrid, 'delete']),
            'row_action' => OptionInterface::ACTION_DELETE,
        ]));

        $eventHandlers->add(new ProcessEventHandler([
            'function' => $this->getFunction('process')
        ]));

        $eventHandlers->add(new LoadedEventHandler([
            'function' => $this->getFunction('dataLoaded')
        ]));

        $datagrid->setOptions($this->options);
    }
}