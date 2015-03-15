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

namespace WellCommerce\Bundle\CategoryBundle\DataSet\Admin;

use WellCommerce\Bundle\DataSetBundle\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\QueryBuilderInterface;
use WellCommerce\Bundle\MultiStoreBundle\Context\ShopContext;

/**
 * Class CategoryDataSetQueryBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryDataSetQueryBuilder extends AbstractDataSetQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var ShopContext
     */
    protected $context;

    /**
     * @param ShopContext $context
     */
    public function setShopContext(ShopContext $context)
    {
        $this->context = $context;
    }

    /**
     * Adds additional criteria to query builder. Filters dataset by current shop scope
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        $qb = parent::getQueryBuilder();

        if (null !== $this->context) {
            $expression = $qb->expr()->eq('category_shops.id', ':shop');
            $qb->andWhere($expression);
            $qb->setParameter('shop', $this->context->getCurrentScope()->getId());
        }

        return $qb;
    }
}
