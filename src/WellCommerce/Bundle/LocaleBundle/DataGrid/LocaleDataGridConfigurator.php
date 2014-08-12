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

namespace WellCommerce\Bundle\LocaleBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\ClickRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\EditRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\OptionInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configurator\AbstractConfigurator;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configurator\ConfiguratorInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class LocaleDataGridConfigurator
 *
 * @package WellCommerce\Bundle\LocaleBundle\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleDataGridConfigurator extends AbstractConfigurator implements ConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(DataGridInterface $datagrid)
    {
        $datagrid->setIdentifier($this->identifier);

        $eventHandlers = $this->manager->getOptions()->getEventHandlers();

        $eventHandlers->add(new LoadEventHandler([
            'function' => $this->manager->getXajaxManager()->register([$this->getFunction('load'), $datagrid, 'load'])
        ]));

        $eventHandlers->add(new EditRowEventHandler([
            'function'   => $this->getFunction('edit'),
            'row_action' => OptionInterface::ACTION_EDIT,
            'route'      => $this->manager->getRouter()->generate('admin.locale.edit')
        ]));

        $eventHandlers->add(new ClickRowEventHandler([
            'function' => $this->getFunction('click'),
            'route'    => $this->manager->getRouter()->generate('admin.locale.edit')
        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $function = $this->getFunction('delete'),
            'callback'   => $this->manager->getXajaxManager()->register([$function, $datagrid, 'delete']),
            'row_action' => OptionInterface::ACTION_DELETE,
        ]));

        $datagrid->setRepository($this->repository);

        $datagrid->setManager($this->manager);
    }
}