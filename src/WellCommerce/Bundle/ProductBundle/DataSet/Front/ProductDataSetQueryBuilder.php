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

namespace WellCommerce\Bundle\ProductBundle\DataSet\Front;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\QueryBuilder\QueryBuilderInterface;

/**
 * Class ProductDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSetQueryBuilder extends AbstractDataSetQueryBuilder implements QueryBuilderInterface
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
        $expression = $queryBuilder->expr()->eq('product.enabled', ':enabled1');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled1', true);

        $expression = $queryBuilder->expr()->eq('categories.enabled', ':enabled2');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled2', true);
    }
}