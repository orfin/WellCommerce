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

namespace WellCommerce\Bundle\AppBundle\DataSet\Admin;

use WellCommerce\Bundle\AppBundle\Service\Shop\Context\ShopContextInterface;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class ProductDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSetQueryBuilder extends AbstractDataSetQueryBuilder
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
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $qb = parent::getQueryBuilder($columns, $request);

        if (null !== $this->context) {
            $expression = $qb->expr()->eq('product_shops.id', ':shop');
            $qb->andWhere($expression);
            $qb->setParameter('shop', $this->context->getCurrentShopIdentifier());
        }

        return $qb;
    }
}
