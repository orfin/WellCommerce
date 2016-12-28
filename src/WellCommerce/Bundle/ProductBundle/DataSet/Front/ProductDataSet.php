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

namespace WellCommerce\Bundle\ProductBundle\DataSet\Front;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyRate;
use WellCommerce\Bundle\ProducerBundle\Entity\Producer;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerTranslation;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductTranslation;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class ProductDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'               => 'product.id',
            'sku'              => 'product.sku',
            'enabled'          => 'product.enabled',
            'name'             => 'product_translation.name',
            'shortDescription' => 'product_translation.shortDescription',
            'description'      => 'product_translation.description',
            'route'            => 'IDENTITY(product_translation.route)',
            'weight'           => 'product.weight',
            'netPrice'         => 'product.sellPrice.netAmount',
            'price'            => 'product.sellPrice.grossAmount',
            'discountedPrice'  => 'product.sellPrice.discountedGrossAmount',
            'isDiscountValid'  => 'IF_ELSE(:date BETWEEN IF_NULL(product.sellPrice.validFrom, :date) AND IF_NULL(product.sellPrice.validTo, :date), 1, 0)',
            'finalPrice'       => 'IF_ELSE(:date BETWEEN IF_NULL(product.sellPrice.validFrom, :date) AND IF_NULL(product.sellPrice.validTo, :date), product.sellPrice.discountedGrossAmount, product.sellPrice.grossAmount) * currency_rate.exchangeRate',
            'currency'         => 'product.sellPrice.currency',
            'tax'              => 'sell_tax.value',
            'stock'            => 'product.stock',
            'producerId'       => 'IDENTITY(product.producer)',
            'producerName'     => 'producers_translation.name',
            'category'         => 'categories.id',
            'filteredCategory' => 'filtered_categories.id',
            'categoryName'     => 'categories_translation.name',
            'categoryRoute'    => 'IDENTITY(categories_translation.route)',
            'shop'             => 'product_shops.id',
            'photo'            => 'photos.path',
            'status'           => 'IDENTITY(distinction.status)',
            'variantOption'    => 'IDENTITY(variant_option.attributeValue)',
            'distinctions'     => 'product.id',
            'hierarchy'        => 'product.hierarchy',
            'isStatusValid'    => 'IF_ELSE(:date BETWEEN IF_NULL(distinction.validFrom, :date) AND IF_NULL(distinction.validTo, :date), 1, 0)',
        ]);
        
        $configurator->setColumnTransformers([
            'route'         => $this->getDataSetTransformer('route'),
            'categoryRoute' => $this->getDataSetTransformer('route'),
            'distinctions'  => $this->getDataSetTransformer('distinctions'),
        ]);
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Product::class,
            ProductTranslation::class,
            Producer::class,
            ProducerTranslation::class,
            Category::class,
        ]));
    }
    
    protected function getQueryBuilder(DataSetRequestInterface $request): QueryBuilder
    {
        $queryBuilder = parent::getQueryBuilder($request);
        
        $queryBuilder->leftJoin(
            CurrencyRate::class,
            'currency_rate',
            Expr\Join::WITH,
            'currency_rate.currencyFrom = product.sellPrice.currency AND currency_rate.currencyTo = :targetCurrency'
        );
        
        $queryBuilder->setParameter('targetCurrency', $this->getRequestHelper()->getCurrentCurrency());
        $queryBuilder->setParameter('date', (new \DateTime())->setTime(0, 0, 1));
        
        return $queryBuilder;
    }
    
    protected function getDataSetRequest(array $requestOptions = []): DataSetRequestInterface
    {
        $request = parent::getDataSetRequest($requestOptions);
        $request->addCondition(new Eq('enabled', true));
        
        return $request;
    }
}
