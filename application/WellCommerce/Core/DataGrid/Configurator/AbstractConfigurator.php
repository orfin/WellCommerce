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

namespace WellCommerce\Core\DataGrid\Configurator;

use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Loader\LoaderInterface;
use WellCommerce\Core\DataGrid\Options\OptionsInterface;
use WellCommerce\Core\DataGrid\Query\QueryInterface;

/**
 * Class AbstractConfigurator
 *
 * @package WellCommerce\Core\DataGrid\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractConfigurator
{
    /**
     * @var OptionsInterface
     */
    protected $options;

    /**
     * @var LoaderInterface
     */
    protected $loader;

    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var QueryInterface
     */
    protected $query;

    /**
     * Constructor
     *
     * @param OptionsInterface $options Configurator options
     * @param LoaderInterface  $loader  DataGrid loader instance
     * @param ColumnCollection $columns Collection of DataGrid columns
     * @param QueryInterface   $query   DataGrid query object
     */
    public function __construct(OptionsInterface $options, LoaderInterface $loader, ColumnCollection $columns, QueryInterface $query)
    {
        $this->options = $options;
        $this->loader  = $loader;
        $this->columns = $columns;
        $this->query   = $query;
    }
} 