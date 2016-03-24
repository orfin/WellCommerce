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

namespace WellCommerce\Bundle\PageBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\ShopBundle\Context\ShopContextInterface;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class PageDataSetQueryBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataSetQueryBuilder extends AbstractDataSetQueryBuilder
{
    /**
     * @var ShopContextInterface
     */
    protected $context;

    /**
     * @param ShopContextInterface $context
     */
    public function setShopContext(ShopContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * Adds additional criteria to query builder. Filters dataset by current shop scope
     *
     * @param ColumnCollection        $columns
     * @param DataSetRequestInterface $request
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request) : QueryBuilder
    {
        $queryBuilder = parent::getQueryBuilder($columns, $request);

        if (null !== $this->context) {
            $expression = $queryBuilder->expr()->eq('page_shops.id', ':shop');
            $queryBuilder->andWhere($expression);
            $queryBuilder->setParameter('shop', $this->context->getCurrentShopIdentifier());
        }

        return $queryBuilder;
    }

}
