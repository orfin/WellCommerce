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

namespace WellCommerce\Component\DataSet\QueryBuilder;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Column\ColumnInterface;
use WellCommerce\Component\DataSet\Conditions\ConditionInterface;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Component\DataSet\Repository\DataSetAwareRepositoryInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class DataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class DataSetQueryBuilder implements DataSetQueryBuilderInterface
{
    /**
     * @var DataSetAwareRepositoryInterface
     */
    private $repository;

    /**
     * @var int
     */
    private $paramIteration = 0;

    /**
     * @var ConditionsCollection
     */
    private $conditions;

    /**
     * DataSetQueryBuilder constructor.
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
     * @return QueryBuilder
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request) : QueryBuilder
    {
        $this->conditions = $this->getConditions($request);
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
     * @param DataSetRequestInterface $request
     *
     * @return ConditionsCollection
     */
    private function getConditions(DataSetRequestInterface $request) : ConditionsCollection
    {
        return $request->getConditions();
    }

    /**
     * Prepares an ordering expression
     *
     * @param DataSetRequestInterface $request
     * @param ColumnCollection        $columns
     *
     * @return Expr\OrderBy
     */
    private function getOrderByExpression(DataSetRequestInterface $request, ColumnCollection $columns) : Expr\OrderBy
    {
        $column   = $columns->get($request->getOrderBy());
        $orderBy  = ($column->isAggregated()) ? $column->getAlias() : $column->getSource();
        $orderDir = $request->getOrderDir();

        return new Expr\OrderBy($orderBy, $orderDir);
    }

    /**
     * Adds additional conditions to query
     *
     * @param QueryBuilder     $queryBuilder
     * @param ColumnCollection $columns
     */
    private function setColumnConditions(QueryBuilder $queryBuilder, ColumnCollection $columns)
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
    private function addColumnConditionToQueryBuilder(QueryBuilder $queryBuilder, ColumnInterface $column, ConditionInterface $condition)
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
