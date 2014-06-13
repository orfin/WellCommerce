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

use Illuminate\Database\Capsule\Manager;
use WellCommerce\Core\Component\DataGrid\Column\ColumnCollection;

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
     * Initializes DataGrid columns
     *
     * @param ColumnCollection $columns
     *
     * @return mixed
     */
    public function initColumns(ColumnCollection $columns);

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
     * Sets query builder object
     *
     * @param Manager $manager
     *
     * @return mixed
     */
    public function setQuery(Manager $manager);
}