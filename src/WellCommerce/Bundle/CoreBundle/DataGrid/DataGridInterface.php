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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\Options\OptionsInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequestInterface;

/**
 * Interface DataGridInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid
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
    public function getIdentifier();

    /**
     * Returns current DataGrid instance
     *
     * @return DataGridInterface
     */
    public function getInstance();

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
    public function getColumns();

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
     * Forwards request to dataset and returns results
     *
     * @param DataSetRequestInterface $request
     *
     * @return mixed
     */
    public function loadResults(Request $request);
}
