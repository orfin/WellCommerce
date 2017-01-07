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

namespace WellCommerce\Bundle\OrderBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class OrderDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'                  => 'orders.id',
            'number'              => 'orders.number',
            'client'              => 'CONCAT_WS(\':\', orders.billingAddress.firstName, orders.billingAddress.lastName, orders.contactDetails.phone)',
            'productTotal'        => 'orders.productTotal.grossPrice',
            'products'            => 'GROUP_CONCAT(DISTINCT product_translation.name ORDER BY product_translation.name ASC SEPARATOR \'<br />\')',
            'productsFull'        => 'GROUP_CONCAT(DISTINCT order_product.id SEPARATOR \',\')',
            'orderTotal'          => 'orders.summary.grossAmount',
            'paymentMethodId'     => 'IDENTITY(orders.paymentMethod)',
            'paymentMethodName'   => 'payment_method_translation.name',
            'shippingMethodId'    => 'IDENTITY(orders.shippingMethod)',
            'shippingMethodName'  => 'shipping_method_translation.name',
            'currentStatusId'     => 'IDENTITY(orders.currentStatus)',
            'currentStatusName'   => 'status_translation.name',
            'currentStatusColour' => 'status.colour',
            'currency'            => 'orders.currency',
            'createdAt'           => 'orders.createdAt',
            'shop'                => 'IDENTITY(orders.shop)',
        ]);
        
        $configurator->setColumnTransformers([
            'createdAt'    => $this->getDataSetTransformer('date', ['format' => 'Y-m-d H:i:s']),
            'client'       => $this->getDataSetTransformer('order_client'),
            'productsFull' => $this->getDataSetTransformer('order_products'),
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('orders.id');
        $queryBuilder->leftJoin('orders.currentStatus', 'status');
        $queryBuilder->leftJoin('status.translations', 'status_translation');
        $queryBuilder->leftJoin('orders.paymentMethod', 'payment_method');
        $queryBuilder->leftJoin('payment_method.translations', 'payment_method_translation');
        $queryBuilder->leftJoin('orders.shippingMethod', 'shipping_method');
        $queryBuilder->leftJoin('shipping_method.translations', 'shipping_method_translation');
        $queryBuilder->leftJoin('orders.products', 'order_product');
        $queryBuilder->leftJoin('order_product.product', 'product');
        $queryBuilder->leftJoin('product.translations', 'product_translation');
        $queryBuilder->where($queryBuilder->expr()->eq('orders.shop', $this->getShopStorage()->getCurrentShopIdentifier()));
        $queryBuilder->andWhere($queryBuilder->expr()->eq('orders.confirmed', true));
        
        return $queryBuilder;
    }
}
