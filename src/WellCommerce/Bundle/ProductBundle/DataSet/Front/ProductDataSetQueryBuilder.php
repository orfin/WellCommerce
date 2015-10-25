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

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\DataSetBundle\Column\ColumnCollection;
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
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * @param RequestHelperInterface $requestHelper
     */
    public function setRequestHelper(RequestHelperInterface $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $qb = parent::getQueryBuilder($columns, $request);

        $this->addProductConditions($qb);
        $this->addCategoryConditions($qb);
        $this->addCurrencyRateConditions($qb);

        $qb->setParameter('date', new \DateTime());


        return $qb;
    }

    /**
     * Adds an additional left-join to currency_rate to calculate final prices in dataset
     *
     * @param QueryBuilder $queryBuilder
     */
    private function addCurrencyRateConditions(QueryBuilder $queryBuilder)
    {
        $queryBuilder->leftJoin(
            'WellCommerce\Bundle\IntlBundle\Entity\CurrencyRate',
            'currency_rate',
            Expr\Join::WITH,
            'currency_rate.currencyFrom = product.sellPrice.currency AND currency_rate.currencyTo = :targetCurrency'
        );

        $queryBuilder->setParameter('targetCurrency', $this->requestHelper->getCurrentCurrency());
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
