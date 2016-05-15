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
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyRate;
use WellCommerce\Bundle\ProducerBundle\Entity\Producer;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerTranslation;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductTranslation;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
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
     * @var RequestHelperInterface
     */
    private $requestHelper;

    public function setRequestHelper(RequestHelperInterface $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    /**
     * {@inheritdoc}
     */
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
        ]);

        $configurator->setColumnTransformers([
            'route' => $this->getDataSetTransformer('route'),
        ]);

        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Product::class,
            ProductTranslation::class,
            Producer::class,
            ProducerTranslation::class,
            Category::class
        ]));
    }
    
    protected function getQueryBuilder(DataSetRequestInterface $request) : QueryBuilder
    {
        $queryBuilder = parent::getQueryBuilder($request);

        $this->filterNotEnabled($queryBuilder);
        $this->filterZeroPrices($queryBuilder);

        $queryBuilder->leftJoin(
            CurrencyRate::class,
            'currency_rate',
            Expr\Join::WITH,
            'currency_rate.currencyFrom = product.sellPrice.currency AND currency_rate.currencyTo = :targetCurrency'
        );

        $queryBuilder->setParameter('targetCurrency', $this->requestHelper->getCurrentCurrency());
        $queryBuilder->setParameter('date', (new \DateTime())->setTime(0, 0, 1));

        return $queryBuilder;
    }

    private function filterNotEnabled(QueryBuilder $queryBuilder)
    {
        $expression = $queryBuilder->expr()->eq('product.enabled', ':enabled1');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled1', true);

        $expression = $queryBuilder->expr()->eq('categories.enabled', ':enabled2');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('enabled2', true);
    }

    private function filterZeroPrices(QueryBuilder $queryBuilder)
    {
        $expression = $queryBuilder->expr()->gt('product.sellPrice.grossAmount', ':price');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('price', 0);
    }
}
