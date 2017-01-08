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
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

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
            'isDiscountValid'  => 'IF_ELSE(:date BETWEEN IF_NULL(product.sellPrice.validFrom, :date) AND IF_NULL(product.sellPrice.validTo, :date) AND product.sellPrice.discountedGrossAmount > 0, 1, 0)',
            'finalPrice'       => 'IF_ELSE(:date BETWEEN IF_NULL(product.sellPrice.validFrom, :date) AND IF_NULL(product.sellPrice.validTo, :date) AND product.sellPrice.discountedGrossAmount > 0, product.sellPrice.discountedGrossAmount, product.sellPrice.grossAmount) * currency_rate.exchangeRate',
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
            'route'         => $this->manager->createTransformer('route'),
            'categoryRoute' => $this->manager->createTransformer('route'),
            'distinctions'  => $this->manager->createTransformer('distinctions'),
        ]);
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Product::class,
            ProductTranslation::class,
            Producer::class,
            ProducerTranslation::class,
            Category::class,
        ]));
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('product.id');
        $queryBuilder->leftJoin('product.translations', 'product_translation');
        $queryBuilder->leftJoin('product.categories', 'categories');
        $queryBuilder->leftJoin('product.categories', 'filtered_categories');
        $queryBuilder->leftJoin('product.producer', 'producers');
        $queryBuilder->leftJoin('product.sellPriceTax', 'sell_tax');
        $queryBuilder->leftJoin('categories.translations', 'categories_translation');
        $queryBuilder->leftJoin('producers.translations', 'producers_translation');
        $queryBuilder->leftJoin('product.productPhotos', 'gallery', Expr\Join::WITH, 'gallery.mainPhoto = :mainPhoto');
        $queryBuilder->leftJoin('gallery.photo', 'photos');
        $queryBuilder->leftJoin('product.distinctions', 'distinction', Expr\Join::WITH, 'distinction.status = :status');
        $queryBuilder->leftJoin('product.shops', 'product_shops');
        $queryBuilder->leftJoin('product.variants', 'variant', Expr\Join::WITH, 'variant.enabled = :variantEnabled');
        $queryBuilder->leftJoin('variant.options', 'variant_option');
        $queryBuilder->leftJoin(
            CurrencyRate::class,
            'currency_rate',
            Expr\Join::WITH,
            'currency_rate.currencyFrom = product.sellPrice.currency AND currency_rate.currencyTo = :targetCurrency'
        );
        $queryBuilder->where($queryBuilder->expr()->eq('product_shops.id', $this->getShopStorage()->getCurrentShopIdentifier()));
        $queryBuilder->andWhere($queryBuilder->expr()->eq('product.enabled', true));
        $queryBuilder->setParameter('mainPhoto', 1);
        $queryBuilder->setParameter('status', 0);
        $queryBuilder->setParameter('variantEnabled', 1);
        $queryBuilder->setParameter('targetCurrency', $this->getRequestHelper()->getCurrentCurrency());
        $queryBuilder->setParameter('date', (new \DateTime())->setTime(0, 0, 1));
        
        return $queryBuilder;
    }
}
