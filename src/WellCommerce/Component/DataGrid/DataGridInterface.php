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

namespace WellCommerce\Component\DataGrid;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Options\OptionsInterface;

/**
 * Interface DataGridInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataGridInterface
{
    const ACTION_DELETE_GROUP = 'GF_Datagrid.ACTION_DELETE_GROUP';
    const ACTION_VIEW         = 'GF_Datagrid.ACTION_VIEW';
    const ACTION_EDIT         = 'GF_Datagrid.ACTION_EDIT';
    const ACTION_DELETE       = 'GF_Datagrid.ACTION_DELETE';
    const REDIRECT            = 'GF_Datagrid.Redirect';
    const OPERATOR_NE         = '!=';
    const OPERATOR_LE         = '<=';
    const OPERATOR_GE         = '>=';
    const OPERATOR_LIKE       = 'LIKE';
    const OPERATOR_IN         = '=';
    const DATAGRID_INIT_EVENT = 'datagrid.init';
    const GF_NULL             = 'GF.NULL';
    
    /**
     * Returns an identifier
     *
     * @return string
     */
    public function getIdentifier() : string;
    
    /**
     * Returns current DataGrid instance
     *
     * @return DataGridInterface
     */
    public function getInstance() : DataGridInterface;
    
    /**
     * Sets DataGrid columns
     *
     * @param ColumnCollection $columns
     *
     * @return void
     */
    public function setColumns(ColumnCollection $columns);
    
    /**
     * Returns columns collection
     *
     * @return ColumnCollection
     */
    public function getColumns() : ColumnCollection;
    
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
    public function getOptions() : OptionsInterface;
    
    /**
     * Forwards request to dataset and returns results
     *
     * @param Request $request
     *
     * @return array
     */
    public function loadResults(Request $request) : array;
}
