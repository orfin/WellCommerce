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

namespace WellCommerce\Component\DataSet;

use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Interface DataSetInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetInterface
{
    /**
     * Returns dataset columns
     *
     * @return ColumnCollection
     */
    public function getColumns() : ColumnCollection;
    
    /**
     * Sets dataset columns
     *
     * @param ColumnCollection $columns
     */
    public function setColumns(ColumnCollection $columns);
    
    /**
     * Adds default request's option
     *
     * @param string $name
     * @param mixed  $value
     */
    public function setDefaultRequestOption(string $name, $value);
    
    /**
     * Adds default context's option
     *
     * @param string $name
     * @param mixed  $value
     */
    public function setDefaultContextOption(string $name, $value);
    
    /**
     * Returns the dataset's result for given context type and options
     *
     * @param string $contextType
     * @param array  $requestOptions
     * @param array  $contextOptions
     *
     * @return array
     */
    public function getResult(string $contextType, array $requestOptions = [], array $contextOptions = []) : array;
    
    /**
     * Configures dataset options
     *
     * @param DataSetConfiguratorInterface $resolver
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator);
    
    /**
     * Dispatches the init event using event-dispatcher service
     *
     * @return void
     */
    public function dispatchOnDataSetInitEvent();
    
    /**
     * @param CacheOptions $options
     */
    public function setCacheOptions(CacheOptions $options);
}
