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

namespace WellCommerce\Bundle\OrderBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;

/**
 * Class OrderRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderRepository extends EntityRepository implements OrderRepositoryInterface
{
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->leftJoin('orders.currentStatus', 'status');
        $queryBuilder->leftJoin('status.translations', 'status_translation');
        $queryBuilder->leftJoin('orders.paymentMethod', 'payment_method');
        $queryBuilder->leftJoin('payment_method.translations', 'payment_method_translation');
        $queryBuilder->leftJoin('orders.shippingMethod', 'shipping_method');
        $queryBuilder->leftJoin('shipping_method.translations', 'shipping_method_translation');
        $queryBuilder->leftJoin('orders.products', 'order_product');
        $queryBuilder->leftJoin('order_product.product', 'product');
        $queryBuilder->leftJoin('product.translations', 'product_translation');
        $queryBuilder->groupBy('orders.id');
        
        return $queryBuilder;
    }
    
    public function getClientOrdersCollection(ClientInterface $client) : Collection
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->eq('client', $client));
        $criteria->andWhere($criteria->expr()->eq('confirmed', true));
        
        return $this->matching($criteria);
    }
    
    public function getAlias() : string
    {
        return 'orders';
    }
}
