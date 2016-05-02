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

namespace WellCommerce\Bundle\ClientBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

/**
 * Class ClientGroupRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupRepository extends EntityRepository implements ClientGroupRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('client_group.id');
        $queryBuilder->leftJoin('client_group.translations', 'client_group_translation');
        $queryBuilder->leftJoin('client_group.clients', 'client');

        return $queryBuilder;
    }
}
