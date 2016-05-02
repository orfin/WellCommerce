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
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

/**
 * Class OrderStatusRepository
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusRepository extends EntityRepository implements OrderStatusRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('order_status.id');
        $queryBuilder->leftJoin('order_status.translations', 'order_status_translation');
        $queryBuilder->leftJoin('order_status.orderStatusGroup', 'order_status_group');
        $queryBuilder->leftJoin('order_status_group.translations', 'order_status_group_translation');
        
        return $queryBuilder;
    }
}
