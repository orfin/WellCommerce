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

namespace WellCommerce\Core\DataSet\Configurator;

use WellCommerce\Core\AbstractComponent;
use WellCommerce\Core\DataSet\Column\ColumnCollection;
use WellCommerce\Core\DataSet\Paginator\PaginatorInterface;
use WellCommerce\Core\DataSet\QueryBuilder\QueryBuilderInterface;

/**
 * Class AbstractConfigurator
 *
 * @package WellCommerce\Core\DataSet\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractConfigurator extends AbstractComponent
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var QueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * Constructor
     *
     * @param                       $identifier
     * @param ColumnCollection      $columns
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct($identifier, ColumnCollection $columns, QueryBuilderInterface $queryBuilder, PaginatorInterface $paginator)
    {
        $this->identifier   = $identifier;
        $this->columns      = $columns;
        $this->queryBuilder = $queryBuilder;
        $this->paginator    = $paginator;
    }
}