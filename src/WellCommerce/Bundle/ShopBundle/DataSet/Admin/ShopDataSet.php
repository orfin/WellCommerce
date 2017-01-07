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

namespace WellCommerce\Bundle\ShopBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class CompanyDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'       => 'shop.id',
            'name'     => 'shop.name',
            'url'      => 'shop.url',
            'theme'    => 'shop_theme.name',
            'company'  => 'shop_company.name',
            'currency' => 'shop.defaultCurrency',
            'country'  => 'shop.defaultCountry',
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('shop.id');
        $queryBuilder->leftJoin('shop.theme', 'shop_theme');
        $queryBuilder->leftJoin('shop.company', 'shop_company');
        
        return $queryBuilder;
    }
}
