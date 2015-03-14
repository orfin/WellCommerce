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

namespace WellCommerce\Bundle\CategoryBundle\DataSet\Front;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CategoryBundle\DataSet\Admin\CategoryDataSetQueryBuilder as BaseQueryBuilder;

/**
 * Class CategoryDataSetQueryBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryDataSetQueryBuilder extends BaseQueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder()
    {
        $queryBuilder = $this->repository->getDataSetQueryBuilder();
        $this->addQueryBuilderRestrictions($queryBuilder);

        return $queryBuilder;
    }

    /**
     * Adds base restrictions to query
     *
     * @param QueryBuilder $queryBuilder
     */
    protected function addQueryBuilderRestrictions(QueryBuilder $queryBuilder)
    {
        // show only enabled categories
        $expression = $queryBuilder->expr()->eq('category.enabled', ':enabled');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled', true);
    }
}
