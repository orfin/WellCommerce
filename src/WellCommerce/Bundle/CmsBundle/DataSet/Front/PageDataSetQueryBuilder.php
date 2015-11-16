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

namespace WellCommerce\Bundle\CmsBundle\DataSet\Front;

use WellCommerce\Bundle\CmsBundle\DataSet\Admin\PageDataSetQueryBuilder as BaseQueryBuilder;
use WellCommerce\Bundle\DataSetBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\Request\DataSetRequestInterface;

/**
 * Class PageDataSetQueryBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataSetQueryBuilder extends BaseQueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $qb         = parent::getQueryBuilder($columns, $request);
        $expression = $qb->expr()->eq('page.publish', ':publish');
        $qb->andWhere($expression);
        $qb->setParameter('publish', true);

        return $qb;
    }
}
