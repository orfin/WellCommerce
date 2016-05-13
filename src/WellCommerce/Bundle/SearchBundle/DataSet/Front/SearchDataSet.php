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

namespace WellCommerce\Bundle\SearchBundle\DataSet\Front;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\ProductBundle\DataSet\Front\ProductDataSet;
use WellCommerce\Bundle\SearchBundle\Manager\SearchManagerInterface;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class SearchDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchDataSet extends ProductDataSet
{
    /**
     * @var SearchManagerInterface
     */
    private $manager;

    public function setSearchManager(SearchManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'               => 'product.id',
            'name'             => 'product_translation.name',
            'shortDescription' => 'product_translation.shortDescription',
            'description'      => 'product_translation.description',
            'route'            => 'IDENTITY(product_translation.route)',
            'weight'           => 'product.weight',
            'price'            => 'product.sellPrice.grossAmount',
            'discountedPrice'  => 'product.sellPrice.discountedGrossAmount',
            'isDiscountValid'  => 'IF_ELSE(:date BETWEEN product.sellPrice.validFrom AND product.sellPrice.validTo, 1, 0)',
            'finalPrice'       => 'IF_ELSE(:date BETWEEN product.sellPrice.validFrom AND product.sellPrice.validTo, product.sellPrice.discountedGrossAmount, product.sellPrice.grossAmount) * currency_rate.exchangeRate',
            'currency'         => 'product.sellPrice.currency',
            'tax'              => 'sell_tax.value',
            'stock'            => 'product.stock',
            'producerId'       => 'IDENTITY(product.producer)',
            'producerName'     => 'producers_translation.name',
            'category'         => 'categories.id',
            'shop'             => 'product_shops.id',
            'photo'            => 'photos.path',
            'status'           => 'statuses.id',
            'score'            => 'FIELD(product.id, :scores)',
        ]);
        
        $configurator->setColumnTransformers([
            'route' => $this->getDataSetTransformer('route')
        ]);
    }
    
    protected function getQueryBuilder(DataSetRequestInterface $request) : QueryBuilder
    {
        $identifiers  = $this->manager->getResultIdentifiers();
        $queryBuilder = parent::getQueryBuilder($request);
        $expression   = $queryBuilder->expr()->in('product.id', ':identifiers');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('identifiers', $identifiers);
        $queryBuilder->setParameter('scores', $this->manager->getResultIdentifiers());

        return $queryBuilder;
    }
}
