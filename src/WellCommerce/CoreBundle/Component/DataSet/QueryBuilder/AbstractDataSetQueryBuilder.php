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

namespace WellCommerce\CoreBundle\Component\DataSet\QueryBuilder;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\CoreBundle\Component\DataSet\Column\ColumnCollection;
use WellCommerce\CoreBundle\Component\DataSet\Column\ColumnInterface;
use WellCommerce\CoreBundle\Component\DataSet\Conditions\ConditionInterface;
use WellCommerce\CoreBundle\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\CoreBundle\Component\DataSet\Repository\DataSetAwareRepositoryInterface;
use WellCommerce\CoreBundle\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class DataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSetQueryBuilder implements DataSetQueryBuilderInterface
{
    /**
     * @var DataSetAwareRepositoryInterface
     */
    protected $repository;

    /**
     * @var int
     */
    protected $paramIteration = 0;

    /**
     * @var ConditionsCollection
     */
    protected $conditions;

    /**
     * Constructor
     *
     * @param DataSetAwareRepositoryInterface $repository
     */
    public function __construct(DataSetAwareRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Prepares and returns Doctrine's QueryBuilder
     *
     * @param ColumnCollection        $columns
     * @param DataSetRequestInterface $request
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $this->conditions = $request->getConditions();
        $queryBuilder     = $this->repository->getDataSetQueryBuilder();

        $queryBuilder->select($columns->getSelectClause());
        $queryBuilder->addOrderBy($this->getOrderByExpression($request, $columns));
        $queryBuilder->setFirstResult($request->getOffset());
        $this->setColumnConditions($queryBuilder, $columns);

        if ($request->getLimit() > 0) {
            $queryBuilder->setMaxResults($request->getLimit());
        }

        return $queryBuilder;
    }

    /**
     * Returns the query conditions
     *
     * @return ConditionsCollection
     */
    protected function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Prepares an ordering expression
     *
     * @param DataSetRequestInterface $request
     * @param ColumnCollection        $columns
     *
     * @return Expr\OrderBy
     */
    protected function getOrderByExpression(DataSetRequestInterface $request, ColumnCollection $columns)
    {
        $column   = $columns->get($request->getOrderBy());
        $orderBy  = ($column->isAggregated()) ? $column->getAlias() : $column->getSource();
        $orderDir = $request->getOrderDir();

        return new Expr\OrderBy($orderBy, $orderDir);
    }

    /**
     * Adds additional conditions to query
     *
     * @param QueryBuilder         $queryBuilder
     * @param ColumnCollection     $columns
     */
    protected function setColumnConditions(QueryBuilder $queryBuilder, ColumnCollection $columns)
    {
        foreach ($this->conditions->all() as $condition) {
            $column = $columns->get($condition->getIdentifier());
            $this->addColumnConditionToQueryBuilder($queryBuilder, $column, $condition);
        }
    }

    /**
     * Adds additional where/having clauses for given dataset's column
     *
     * @param QueryBuilder       $queryBuilder
     * @param ColumnInterface    $column
     * @param ConditionInterface $condition
     */
    protected function addColumnConditionToQueryBuilder(QueryBuilder $queryBuilder, ColumnInterface $column, ConditionInterface $condition)
    {
        $source     = $column->getSource();
        $alias      = $column->getAlias();
        $operator   = $condition->getOperator();
        $identifier = sprintf('%s_%s', $condition->getIdentifier(), $this->paramIteration++);

        if ($column->isAggregated()) {
            $expression = $queryBuilder->expr()->{$operator}($alias, ':' . $identifier);
            $queryBuilder->andHaving($expression);
        } else {
            $expression = $queryBuilder->expr()->{$operator}($source, ':' . $identifier);
            $queryBuilder->andWhere($expression);
        }

        $queryBuilder->setParameter($identifier, $condition->getValue());
    }
}
