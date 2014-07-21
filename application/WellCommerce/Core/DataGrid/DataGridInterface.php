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

use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Loader\LoaderInterface;
use WellCommerce\Core\DataGrid\Options\OptionsInterface;
use WellCommerce\Core\DataGrid\Query\QueryInterface;

/**
 * Interface DataGridInterface
 *
 * @package WellCommerce\Core\DataGrid
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
     * Adds new columns to collection
     *
     * @return void
     */
    public function addColumns();

    /**
     * Sets columns collection
     *
     * @param ColumnCollection $columns
     *
     * @return mixed
     */
    public function setColumns(ColumnCollection $columns);

    /**
     * Sets query builder object
     *
     * @param QueryInterface $query
     *
     * @return mixed
     */
    public function setQuery(QueryInterface $query);

    /**
     * Sets DataGrid options
     *
     * @param OptionsInterface $options
     *
     * @return void
     */
    public function setOptions(OptionsInterface $options);
}