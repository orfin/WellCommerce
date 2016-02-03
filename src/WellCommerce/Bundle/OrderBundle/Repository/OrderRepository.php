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

use WellCommerce\Bundle\DoctrineBundle\Repository\AbstractEntityRepository;

/**
 * Class OrderRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderRepository extends AbstractEntityRepository implements OrderRepositoryInterface
{
    public function getDataSetQueryBuilder()
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->leftJoin('orders.currentStatus', 'status');
        $queryBuilder->leftJoin('status.translations', 'status_translation');
        $queryBuilder->groupBy('orders.id');

        return $queryBuilder;
    }

    public function getAlias()
    {
        return 'orders';
    }
}
