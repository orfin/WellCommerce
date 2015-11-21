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

namespace WellCommerce\CoreBundle\Component\DataSet\Paginator;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use WellCommerce\CoreBundle\Component\DataSet\Column\ColumnCollection;

/**
 * Class DataSetPaginator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetPaginator implements DataSetPaginatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTotalRows(QueryBuilder $queryBuilder, ColumnCollection $columns)
    {
        $builder = clone $queryBuilder;
        $having  = $builder->getDQLPart('having');
        if (is_object($having)) {
            $this->replaceHaving($having, $columns, $builder);
        }

        $query     = $builder->getQuery();
        $paginator = new Paginator($query, true);
        $paginator->setUseOutputWalkers(false);

        return $paginator->count();
    }

    /**
     * Replaces all having clauses and resets DQL's having part
     *
     * @param Query\Expr\Andx  $having
     * @param ColumnCollection $columns
     * @param QueryBuilder     $queryBuilder
     */
    protected function replaceHaving(Query\Expr\Andx $having, ColumnCollection $columns, QueryBuilder $queryBuilder)
    {
        foreach ($having->getParts() as $part) {
            $this->replaceSingleHavingClause($part, $columns, $queryBuilder);
        }

        $queryBuilder->resetDQLPart('having');
    }

    /**
     * Replaces a single having clause because scalar types are not supported in doctrine paginator by default
     *
     * @param Query\Expr\Comparison $comparison
     * @param ColumnCollection      $columns
     * @param QueryBuilder          $queryBuilder
     */
    protected function replaceSingleHavingClause(Query\Expr\Comparison $comparison, ColumnCollection $columns, QueryBuilder $queryBuilder)
    {
        $source     = $columns->get($comparison->getLeftExpr())->getSource();
        $param      = $comparison->getRightExpr();
        $operator   = $this->getOperator($comparison->getOperator());
        $expression = $queryBuilder->expr()->{$operator}($source, $param);
        $queryBuilder->andWhere($expression);
    }

    protected function getOperator($operator)
    {
        switch ($operator) {
            case Query\Expr\Comparison::EQ:
                return 'eq';
                break;
            case Query\Expr\Comparison::NEQ:
                return 'neq';
                break;
            case Query\Expr\Comparison::LT:
                return 'lt';
                break;
            case Query\Expr\Comparison::LTE:
                return 'lte';
                break;
            case Query\Expr\Comparison::GT:
                return 'gt';
                break;
            case Query\Expr\Comparison::GTE:
                return 'gte';
                break;
            default:
                return 'eq';
        }
    }
}
