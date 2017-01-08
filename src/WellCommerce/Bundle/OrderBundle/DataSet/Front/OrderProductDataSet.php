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

use Doctrine\ORM\Query\Expr;
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
            'id'          => 'order_product.id',
            'grossAmount' => 'order_product.sellPrice.grossAmount',
            'netAmount'   => 'order_product.sellPrice.netAmount',
            'taxAmount'   => 'order_product.sellPrice.taxAmount',
            'currency'    => 'order_product.sellPrice.currency',
            'stock'       => 'IF_ELSE(order_product.variant IS NOT NULL, product_variant.stock, product.stock)',
            'weight'      => 'IF_ELSE(order_product.variant IS NOT NULL, product_variant.weight, product.weight)',
            'quantity'    => 'order_product.quantity',
            'variant'     => 'IDENTITY(order_product.variant)',
            'options'     => 'order_product.options',
            'name'        => 'product_translation.name',
            'route'       => 'IDENTITY(product_translation.route)',
            'tax'         => 'sell_tax.value',
            'photo'       => 'photos.path',
        ]);
        
        $configurator->setColumnTransformers([
            'route' => $this->manager->createTransformer('route'),
        ]);
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Order::class,
            OrderProduct::class,
            Product::class,
            Variant::class,
            Tax::class,
        ]));
    }
    
    public function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('order_product.id');
        $queryBuilder->leftJoin('order_product.product', 'product');
        $queryBuilder->leftJoin('order_product.variant', 'product_variant');
        $queryBuilder->leftJoin('product.translations', 'product_translation');
        $queryBuilder->leftJoin('product.sellPriceTax', 'sell_tax');
        $queryBuilder->leftJoin('product.productPhotos', 'gallery', Expr\Join::WITH, 'gallery.mainPhoto = :mainPhoto');
        $queryBuilder->leftJoin('gallery.photo', 'photos');
        $queryBuilder->andWhere($queryBuilder->expr()->eq('order_product.order', ':order'));
        $queryBuilder->setParameter('order', $this->getOrderProvider()->getCurrentOrderIdentifier());
        $queryBuilder->setParameter('mainPhoto', 1);
        
        return $queryBuilder;
    }
    
    private function getOrderProvider(): OrderProviderInterface
    {
        return $this->get('order.provider.front');
    }
}
