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
     * Sets query object
     *
     * @param QueryInterface $query
     *
     * @return mixed
     */
    public function setQuery(QueryInterface $query);

    /**
     * Loads DataGrid results
     *
     * @param RequestInterface $request
     *
     * @return mixed
     */
    public function load(RequestInterface $request);

    /**
     * Returns DataGrid results
     *
     * @return array
     */
    public function get(array $options);

    /**
     * Post-processes returned rows
     *
     * @return array
     */
    public function process($result);
} 