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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\QueryBuilder;

/**
 * Interface QueryBuilderInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Query
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface QueryBuilderInterface
{
    /**
     * Returns current DataGrid query builder
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQuery();

    /**
     * Returns entity repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository();

    /**
     * Transforms and returns operator used in where clauses
     *
     * @param $operator
     *
     * @return string
     */
    public function getOperator($operator);
} 