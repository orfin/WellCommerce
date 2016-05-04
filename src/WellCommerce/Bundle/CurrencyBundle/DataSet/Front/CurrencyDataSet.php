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

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CurrencyBundle\Entity\Currency;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class CurrencyDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class CurrencyDataSet extends AbstractDataSet
{
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'   => 'currency.id',
            'code' => 'currency.code',
        ]);
        
        $this->setDefaultRequestOption('order_by', 'code');
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Currency::class
        ]));
    }
    
    protected function getQueryBuilder(DataSetRequestInterface $request) : QueryBuilder
    {
        $queryBuilder = parent::getQueryBuilder($request);
        $expression   = $queryBuilder->expr()->eq('currency.enabled', ':enabled');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled', true);

        return $queryBuilder;
    }
}
