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

namespace WellCommerce\Bundle\DataSetBundle\QueryBuilder;

use WellCommerce\Bundle\DataSetBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;

/**
 * Interface QueryBuilderInterface
 *
 * @package WellCommerce\Bundle\DataSetBundle\QueryBuilder
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface QueryBuilderInterface
{
    const SORT_DIR_ASC  = 'ASC';
    const SORT_DIR_DESC = 'DESC';

    /**
     * Returns Doctrine query object
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQuery();

    /**
     * Sets columns to select
     *
     * @param ColumnCollection $collection
     *
     * @return void
     */
    public function setColumns(ColumnCollection $collection);

    /**
     * Sets sorting clauses
     *
     * @param $sort
     * @param $order
     *
     * @return mixed
     */
    public function setOrderBy($sort, $order);

    /**
     * Sets limiting clauses
     *
     * @param $offset
     * @param $limit
     *
     * @return mixed
     */
    public function setPagination($offset, $limit);

    /**
     * Sets query conditions
     *
     * @param ConditionsCollection $collection
     *
     * @return mixed
     */
    public function setConditions(ConditionsCollection $collection);

    /**
     * Returns dataset results
     *
     * @return array
     */
    public function getResult();

    /**
     * Returns total results count before filtering
     *
     * @return mixed
     */
    public function getTotalRows();
}
