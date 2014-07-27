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

namespace WellCommerce\ClientGroup\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class ClientGroupDataGridQuery
 *
 * @package WellCommerce\ClientGroup\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('client_group');
        $qb->join('client_group_translation', 'client_group_translation.client_group_id', '=', 'client_group.id');
        $qb->groupBy('client_group.id');

        return $qb;
    }
} 