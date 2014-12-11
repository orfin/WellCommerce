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

use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Manager\DataGridManagerInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Options\OptionsInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;

/**
 * Interface DataGridInterface
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataGridInterface
{
    const ACTION_EDIT         = 'GF_Datagrid.ACTION_EDIT';
    const ACTION_DELETE       = 'GF_Datagrid.ACTION_DELETE';
    const REDIRECT            = 'GF_Datagrid.Redirect';
    const OPERATOR_NE         = '!=';
    const OPERATOR_LE         = '<=';
    const OPERATOR_GE         = '>=';
    const OPERATOR_LIKE       = 'LIKE';
    const OPERATOR_IN         = '=';
    const DATAGRID_INIT_EVENT = 'datagrid.init';
    const GF_NULL             = 'GF.NULL';// GF.NULL - Null equivalent

    /**
     * Sets DataGrid identifier
     *
     * @param string $identifier
     *
     * @return void
     */
    public function setIdentifier($identifier);

    /**
     * Returns an identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Add columns to collection
     *
     * @param ColumnCollection $columnCollection
     *
     * @return mixed
     */
    public function addColumns(ColumnCollection $columnCollection);

    /**
     * Sets columns collection
     *
     * @param ColumnCollection $columns
     *
     * @return mixed
     */
    public function setColumns(ColumnCollection $columns);

    /**
     * Sets datagrid repository
     *
     * @param DataGridAwareRepositoryInterface $repository
     *
     * @return mixed
     */
    public function setRepository(DataGridAwareRepositoryInterface $repository);

    /**
     * Sets manager instance
     *
     * @param DataGridManagerInterface $manager
     *
     * @return mixed
     */
    public function setManager(DataGridManagerInterface $manager);

    /**
     * Returns columns collection
     *
     * @return ColumnCollection
     */
    public function getColumns();

    /**
     * Returns query builder object
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getDataGridQueryBuilder();

    /**
     * Returns current instance
     *
     * @return mixed
     */
    public function getInstance();

    /**
     * Sets DataGrid options
     *
     * @param OptionsInterface $options
     *
     * @return void
     */
    public function setOptions(OptionsInterface $options);

    /**
     * Returns DataGrid options
     *
     * @return OptionsInterface
     */
    public function getOptions();
}