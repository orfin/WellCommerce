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

namespace WellCommerce\Core\Component\DataGrid;

/**
 * Interface DataGridInterface
 *
 * @package WellCommerce\Core\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataGridInterface
{
    const ACTION_EDIT   = 'GF_Datagrid.ACTION_EDIT';
    const ACTION_DELETE = 'GF_Datagrid.ACTION_DELETE';
    const REDIRECT      = 'GF_Datagrid.Redirect';
    const OPERATOR_NE   = '!=';
    const OPERATOR_LE   = '<=';
    const OPERATOR_GE   = '>=';
    const OPERATOR_LIKE = 'LIKE';
    const OPERATOR_IN   = '=';

    /**
     * Sets DataGrid columns
     *
     * @return mixed
     */
    public function initColumns();

    /**
     * Returns DataGrid identifier
     *
     * @return mixed
     */
    public function getId();

    /**
     * Returns routes used in DataGrid
     *
     * @return array
     */
    public function getRoutes();

    /**
     * Sets Eloquent query object for DataGrid instance
     *
     * @return object
     */
    public function setQuery();
}