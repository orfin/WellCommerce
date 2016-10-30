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
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

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
            'id'                 => 'orders.id',
            'number'             => 'orders.number',
            'client'             => 'CONCAT_WS(\':\', orders.billingAddress.firstName, orders.billingAddress.lastName, orders.contactDetails.phone)',
            'productTotal'       => 'orders.productTotal.grossPrice',
            'products'           => 'GROUP_CONCAT(DISTINCT product_translation.name ORDER BY product_translation.name ASC SEPARATOR \'<br />\')',
            'productsFull'       => 'GROUP_CONCAT(DISTINCT order_product.id SEPARATOR \',\')',
            'orderTotal'         => 'orders.summary.grossAmount',
            'paymentMethodName'  => 'payment_method_translation.name',
            'shippingMethodName' => 'shipping_method_translation.name',
            'currentStatusId'    => 'IDENTITY(orders.currentStatus)',
            'currentStatusName'  => 'status_translation.name',
            'currency'           => 'orders.currency',
            'createdAt'          => 'orders.createdAt',
            'shop'               => 'IDENTITY(orders.shop)',
        ]);
        
        $configurator->setColumnTransformers([
            'createdAt'    => $this->getDataSetTransformer('date', ['format' => 'Y-m-d H:i:s']),
            'client'       => $this->getDataSetTransformer('order_client'),
            'productsFull' => $this->getDataSetTransformer('order_products'),
        ]);
    }
    
    protected function getQueryBuilder(DataSetRequestInterface $request) : QueryBuilder
    {
        $queryBuilder = parent::getQueryBuilder($request);
        $expression   = $queryBuilder->expr()->eq('orders.confirmed', ':confirmed');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('confirmed', true);
        
        return $queryBuilder;
    }
    
    protected function getDataSetRequest(array $requestOptions = []) : DataSetRequestInterface
    {
        $request = parent::getDataSetRequest($requestOptions);
        $request->addCondition(new Eq('shop', $this->getShopStorage()->getCurrentShopIdentifier()));
        
        return $request;
    }
}
