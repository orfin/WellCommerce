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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configurator;

use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\ClickRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\EditRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Manager\DataGridManagerInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\OptionInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class AbstractConfigurator
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractConfigurator implements ConfiguratorInterface
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var DataGridManagerInterface
     */
    protected $manager;

    /**
     * @var DataGridAwareRepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param                                  $identifier
     * @param DataGridManagerInterface         $manager
     * @param DataGridAwareRepositoryInterface $repository
     */
    public function __construct(
        $identifier,
        DataGridManagerInterface $manager,
        DataGridAwareRepositoryInterface $repository
    ) {
        $this->identifier = $identifier;
        $this->manager    = $manager;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(DataGridInterface $datagrid)
    {
        $datagrid->setIdentifier($this->identifier);

        $eventHandlers = $this->manager->getOptions()->getEventHandlers();

        $eventHandlers->add(new LoadEventHandler([
            'function' => $this->getFunction('load'),
            'route'    => $this->manager->getRouteForAction('grid')
        ]));

        $eventHandlers->add(new EditRowEventHandler([
            'function'   => $this->getFunction('edit'),
            'row_action' => OptionInterface::ACTION_EDIT,
            'route'      => $this->manager->getRouteForAction('edit')
        ]));

        $eventHandlers->add(new ClickRowEventHandler([
            'function' => $this->getFunction('click'),
            'route'    => $this->manager->getRouteForAction('edit')
        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $this->getFunction('delete'),
            'row_action' => OptionInterface::ACTION_DELETE,
            'route'      => $this->manager->getRouteForAction('delete')
        ]));

        $datagrid->setRepository($this->repository);

        $datagrid->setManager($this->manager);

        return $datagrid;
    }

    protected function getManager()
    {
        return $this->manager;
    }

    /**
     * Returns a function name used in DataGrid events and actions
     *
     * @param $name
     *
     * @return string
     */
    protected function getFunction($name)
    {
        $functionName = sprintf('%s%s', $name, ucfirst($this->identifier));

        return lcfirst(Helper::studly($functionName));
    }
}