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

namespace WellCommerce\Bundle\CmsBundle\DataSet\Admin;

use WellCommerce\Bundle\DataSetBundle\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\QueryBuilderInterface;
use WellCommerce\Bundle\MultiStoreBundle\Context\ShopContextInterface;

/**
 * Class PageDataSetQueryBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataSetQueryBuilder extends AbstractDataSetQueryBuilder implements QueryBuilderInterface
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
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        $qb = parent::getQueryBuilder();

        if (null !== $this->context->getCurrentScopeId()) {
            $expression = $qb->expr()->eq('page_shops.id', ':shop');
            $qb->andWhere($expression);
            $qb->setParameter('shop', $this->context->getCurrentScopeId());
        }

        return $qb;
    }

}
