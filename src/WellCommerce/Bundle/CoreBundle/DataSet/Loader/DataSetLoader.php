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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Loader;

use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Processor\ProcessorInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\QueryBuilder\QueryBuilderInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequestInterface;

/**
 * Class DataSetLoader
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetLoader implements DataSetLoaderInterface
{
    /**
     * @var QueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * Constructor
     *
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(QueryBuilderInterface $queryBuilder, ProcessorInterface $processor)
    {
        $this->queryBuilder = $queryBuilder;
        $this->processor    = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function getResults(DataSetInterface $dataset, DataSetRequestInterface $request)
    {
        $columns = $dataset->getColumns();
        $this->queryBuilder->setColumns($columns);
        $total = $this->queryBuilder->getTotalRows();
        $this->setQueryBuilderParameters($request);

        $rows = $this->queryBuilder->getResult();

        return $this->processor->processResult($dataset, $rows, $total, $request);
    }

    /**
     * Sets query parameters and additional conditions
     *
     * @param DataSetRequestInterface $request
     */
    private function setQueryBuilderParameters(DataSetRequestInterface $request)
    {
        $this->queryBuilder->setOrderBy($request->getOrderBy(), $request->getOrderDir());
        $this->queryBuilder->setPagination($request->getOffset(), $request->getLimit());
        $this->queryBuilder->setConditions($request->getConditions());
    }
}
