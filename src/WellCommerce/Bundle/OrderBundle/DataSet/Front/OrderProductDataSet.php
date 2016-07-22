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

namespace WellCommerce\Bundle\OrderBundle\DataSet\Front;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\OrderBundle\Entity\Order;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProduct;
use WellCommerce\Bundle\OrderBundle\Provider\Front\OrderProviderInterface;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\Variant;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class OrderProductDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductDataSet extends AbstractDataSet
{
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'              => 'order_product.id',
            'price'           => 'IF_ELSE(order_product.variant IS NOT NULL, product_variant.sellPrice.grossAmount, product.sellPrice.grossAmount)',
            'discountedPrice' => 'IF_ELSE(order_product.variant IS NOT NULL, product_variant.sellPrice.discountedGrossAmount, product.sellPrice.discountedGrossAmount)',
            'currency'        => 'IF_ELSE(order_product.variant IS NOT NULL, product_variant.sellPrice.currency, product.sellPrice.currency)',
            'stock'           => 'IF_ELSE(order_product.variant IS NOT NULL, product_variant.stock, product.stock)',
            'weight'          => 'IF_ELSE(order_product.variant IS NOT NULL, product_variant.weight, product.weight)',
            'quantity'        => 'order_product.quantity',
            'variant'         => 'IDENTITY(order_product.variant)',
            'options'         => 'order_product.options',
            'name'            => 'product_translation.name',
            'route'           => 'IDENTITY(product_translation.route)',
            'isDiscountValid' => 'IF_ELSE(:date BETWEEN product.sellPrice.validFrom AND product.sellPrice.validTo, 1, 0)',
            'tax'             => 'sell_tax.value',
            'photo'           => 'photos.path'
        ]);
        
        $configurator->setColumnTransformers([
            'route' => $this->getDataSetTransformer('route'),
        ]);
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Order::class,
            OrderProduct::class,
            Product::class,
            Variant::class,
            Tax::class
        ]));
    }
    
    protected function getQueryBuilder(DataSetRequestInterface $request) : QueryBuilder
    {
        $queryBuilder = parent::getQueryBuilder($request);
        $expression   = $queryBuilder->expr()->eq('order_product.order', ':order');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('order', $this->getOrderProvider()->getCurrentOrderIdentifier());
        $queryBuilder->setParameter('date', (new \DateTime())->setTime(0, 0, 1));
        
        return $queryBuilder;
    }
    
    private function getOrderProvider() : OrderProviderInterface
    {
        return $this->get('order.provider.front');
    }
}
