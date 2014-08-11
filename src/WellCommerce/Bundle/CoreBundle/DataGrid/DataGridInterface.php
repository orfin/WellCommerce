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

use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\Options\OptionsInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Request\RequestInterface;

/**
 * Interface DataGridInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid
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
     * Adds datagrid columns to collection
     *
     * @return mixed
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

    /**
     * Sets current DataGrid request
     *
     * @param RequestInterface $request
     *
     * @return mixed
     */
    public function setCurrentRequest(RequestInterface $request);

    /**
     * Returns current DataGrid request
     *
     * @return RequestInterface
     */
    public function getCurrentRequest();

    /**
     * Updates DataGrid row. Transfers request to repository
     *
     * @param array $request
     *
     * @return mixed
     */
    public function update(array $request);
}