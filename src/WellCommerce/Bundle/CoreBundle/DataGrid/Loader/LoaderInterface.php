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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Loader;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Query\QueryInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Request\RequestInterface;

/**
 * Interface LoaderInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Loader
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
     * @param Request           $request
     *
     * @return mixed
     */
    public function getResults(DataGridInterface $dataGrid, Request $request);

    /**
     * Post-processes returned rows
     *
     * @param $rows
     *
     * @return mixed
     */
    public function processResults($rows);
} 