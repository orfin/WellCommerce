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

use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Core\AbstractComponent;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Options\OptionsInterface;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryInterface;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class AbstractConfigurator
 *
 * @package WellCommerce\Core\DataGrid\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractConfigurator extends AbstractComponent
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var OptionsInterface
     */
    protected $options;

    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var QueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * Constructor
     *
     * @param                       $identifier
     * @param OptionsInterface      $options
     * @param ColumnCollection      $columns
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct($identifier, OptionsInterface $options, ColumnCollection $columns, QueryBuilderInterface $queryBuilder)
    {
        $this->identifier   = $identifier;
        $this->options      = $options;
        $this->columns      = $columns;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Returns a function name used in DataGrid events and actions
     *
     * @param $name
     *
     * @return string
     */
    public function getFunction($name)
    {
        return sprintf('%s%s', $name, ucfirst($this->identifier));
    }

}