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
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\QueryBuilderInterface;

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
        // show only enabled products
        $expression = $queryBuilder->expr()->eq('product.enabled', ':enabled1');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled1', true);

        // show products from enabled categories
        $expression = $queryBuilder->expr()->eq('categories.enabled', ':enabled2');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled2', true);

        // show only products with prices greater than 0
        $expression = $queryBuilder->expr()->gt('product.sellPrice', ':price');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('price', 0);
    }
}
