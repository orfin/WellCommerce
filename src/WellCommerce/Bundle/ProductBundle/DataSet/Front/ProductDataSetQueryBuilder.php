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
use WellCommerce\Bundle\DataSetBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;
use WellCommerce\Bundle\DataSetBundle\Request\DataSetRequestInterface;
use WellCommerce\Bundle\ProductBundle\DataSet\Admin\ProductDataSetQueryBuilder as BaseProductDataSetQueryBuilder;

/**
 * Class ProductDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSetQueryBuilder extends BaseProductDataSetQueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $qb = parent::getQueryBuilder($columns, $request);

        $this->addProductConditions($qb);
        $this->addCategoryConditions($qb);

        $qb->setParameter('date', new \DateTime());

        return $qb;
    }

    /**
     * Adds additional product-related conditions to query
     *
     * @param QueryBuilder $queryBuilder
     */
    private function addProductConditions(QueryBuilder $queryBuilder)
    {
        // show only enabled products
        $expression = $queryBuilder->expr()->eq('product.enabled', ':enabled1');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled1', true);

        // show only products with prices greater than 0
        $expression = $queryBuilder->expr()->gt('product.sellPrice.grossAmount', ':price');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('price', 0);
    }

    /**
     * Adds additional category-related conditions to query
     *
     * @param QueryBuilder $queryBuilder
     */
    private function addCategoryConditions(QueryBuilder $queryBuilder)
    {
        // show products from enabled categories
        $expression = $queryBuilder->expr()->eq('categories.enabled', ':enabled2');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled2', true);
    }
}
