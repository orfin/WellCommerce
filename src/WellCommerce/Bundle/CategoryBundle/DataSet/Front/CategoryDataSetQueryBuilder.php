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
        $qb         = parent::getQueryBuilder();
        $expression = $qb->expr()->eq('category.enabled', ':enabled');
        $qb->andWhere($expression);
        $qb->setParameter('enabled', true);

        return $qb;
    }
}
