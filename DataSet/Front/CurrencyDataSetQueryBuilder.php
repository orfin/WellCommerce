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

namespace WellCommerce\Bundle\CurrencyBundle\DataSet\Front;

use WellCommerce\Bundle\CurrencyBundle\DataSet\Admin\CurrencyDataSetQueryBuilder as BaseDataSetQueryBuilder;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class CurrencyDataSetQueryBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyDataSetQueryBuilder extends BaseDataSetQueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $queryBuilder = parent::getQueryBuilder($columns, $request);
        $expression   = $queryBuilder->expr()->eq('currency.enabled', ':enabled');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled', true);

        return $queryBuilder;
    }
}
