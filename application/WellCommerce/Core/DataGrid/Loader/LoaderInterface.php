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

namespace WellCommerce\Core\DataGrid\Loader;

use WellCommerce\Core\DataGrid\DataGridInterface;
use WellCommerce\Core\DataGrid\Query\QueryInterface;
use WellCommerce\Core\DataGrid\Request\RequestInterface;

/**
 * Interface LoaderInterface
 *
 * @package WellCommerce\Core\DataGrid\Loader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LoaderInterface
{
    /**
     * Executes bounded query and returns results
     *
     * @return mixed
     */
    public function loadResults();

    /**
     * Returns DataGrid results
     *
     * @param DataGridInterface $dataGrid
     *
     * @return mixed
     */
    public function getResults(DataGridInterface $dataGrid);

    /**
     * Post-processes returned rows
     *
     * @param $rows
     *
     * @return mixed
     */
    public function processResults($rows);
} 