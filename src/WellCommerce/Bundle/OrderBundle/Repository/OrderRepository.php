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

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

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
        $queryBuilder->groupBy('orders.id');
        
        return $queryBuilder;
    }

    public function getAlias() : string
    {
        return 'orders';
    }
}
