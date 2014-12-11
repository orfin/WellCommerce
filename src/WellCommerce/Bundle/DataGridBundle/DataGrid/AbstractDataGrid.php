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
namespace WellCommerce\Bundle\DataGridBundle\DataGrid;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Manager\DataGridManagerInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Options\OptionsInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;

/**
 * Class AbstractDataGrid
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGrid extends AbstractContainer implements DataGridInterface
{
    protected $booted = false;
    protected $columns;
    protected $identifier;

    /**
     * @var DataGridAwareRepositoryInterface
     */
    protected $repository;
    protected $loader;
    protected $options;
    protected $queryBuilder;
    protected $request;

    /**
     * {@inheritdoc}
     */
    public function setManager(DataGridManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @var DataGridManagerInterface
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository(DataGridAwareRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->manager->getColumnCollection();
    }

    /**
     * Boots DataGrid if it was not booted
     *
     * @return void
     */
    public function boot()
    {
        $columnCollection = $this->manager->getColumnCollection();

        // adds new columns do collection
        $this->addColumns($columnCollection);

        // sets columns for current datagrid
        $this->setColumns($columnCollection);

        $this->setOptions($this->manager->getOptions());

        $this->booted = true;
    }

    /**
     * Reboots current DataGrid
     */
    public function reboot()
    {
        $this->booted = false;
    }

    /**
     * Returns current DataGrid
     *
     * @return DataGridInterface
     */
    public function getInstance()
    {
        if (!$this->booted) {
            $this->boot();
        }

        return $this;
    }

    public function setOptions(OptionsInterface $options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return $this->repository->getDataGridQueryBuilder();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentRequest()
    {
        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function load(Request $request)
    {
        return $this->manager->getLoader()->getResults($this, $request);
    }
}