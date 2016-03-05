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

namespace WellCommerce\Bundle\LocaleBundle\DataSet\Front;

use WellCommerce\Bundle\LocaleBundle\DataSet\Admin\LocaleDataSetQueryBuilder as BaseDataSetQueryBuilder;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class LocaleDataSetQueryBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleDataSetQueryBuilder extends BaseDataSetQueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $queryBuilder = parent::getQueryBuilder($columns, $request);
        $expression   = $queryBuilder->expr()->eq('locale.enabled', ':enabled');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled', true);

        return $queryBuilder;
    }
}
