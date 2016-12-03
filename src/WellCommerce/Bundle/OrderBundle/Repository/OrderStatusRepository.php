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

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;

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
    public function getDataSetQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('order_status.id');
        $queryBuilder->leftJoin('order_status.translations', 'order_status_translation');
        $queryBuilder->leftJoin('order_status.orderStatusGroup', 'order_status_group');
        $queryBuilder->leftJoin('order_status_group.translations', 'order_status_group_translation');
        
        return $queryBuilder;
    }
    
    public function getDataGridFilterOptions(): array
    {
        $options  = [];
        $statuses = $this->matching(new Criteria());
        $statuses->map(function (OrderStatusInterface $status) use (&$options) {
            $options[] = [
                'id'          => $status->getId(),
                'name'        => $status->translate()->getName(),
                'hasChildren' => false,
                'parent'      => null,
                'weight'      => $status->getId(),
            ];
        });
        
        return $options;
    }
}
