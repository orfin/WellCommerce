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

namespace WellCommerce\Bundle\DataSetBundle\DataSet\QueryBuilder;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Tools\Pagination\Paginator;
use WellCommerce\Bundle\DataSetBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Bundle\DataSetBundle\Doctrine\ORM\DataSetAwareRepositoryInterface;

/**
 * Class DataSetQueryBuilder
 *
 * @package WellCommerce\Bundle\DataSetBundle\DataSet\QueryBuilder
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSetQueryBuilder
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var DataSetAwareRepositoryInterface
     */
    protected $repository;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var string
     */
    protected $orderBy;

    /**
     * @var string
     */
    protected $orderDir;

    /**
     * @var array
     */
    protected $criteria;

    /**
     * Constructor
     *
     * @param DataSetAwareRepositoryInterface $repository
     */
    public function __construct(DataSetAwareRepositoryInterface $repository)
    {
        $this->identifier   = $repository->getAlias();
        $this->queryBuilder = $repository->getDataSetQueryBuilder();
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderBy($sort, $order)
    {
        $this->orderBy  = $this->columns->get($sort)->getSource();
        $this->orderDir = $this->normalizeOrderDir($order);
    }

    /**
     * Normalizes order direction
     *
     * @param $order
     *
     * @return string
     */
    private function normalizeOrderDir($order)
    {
        return in_array(strtolower($order), ['asc', 'desc']) ? strtolower($order) : 'asc';
    }

    /**
     * {@inheritdoc}
     */
    public function setPagination($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit  = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;
    }

    /**
     * {@inheritdoc}
     */
    public function setConditions(ConditionsCollection $conditions = null)
    {
        $expr     = Criteria::expr();
        $criteria = Criteria::create();

        if (null !== $conditions) {
            $criteria->where(
                call_user_func_array([$expr, 'andX'], $conditions->all())
            );
        }

        $this->criteria = $criteria;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        return $this->queryBuilder->getQuery();
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalRows()
    {
        $paginator = new Paginator($this->getQuery());

        return $paginator->count();
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        $this->queryBuilder->select($this->columns->getColumnsSelectClause());
        $this->queryBuilder->setFirstResult($this->offset);
        $this->queryBuilder->setMaxResults($this->limit);
        $this->queryBuilder->addOrderBy(new Expr\OrderBy($this->orderBy, $this->orderDir));
        $this->queryBuilder->addCriteria($this->criteria);

        $query = $this->queryBuilder->getQuery();
        $query->useResultCache(true, 3600, $this->identifier);

        return $query->getArrayResult();
    }
}