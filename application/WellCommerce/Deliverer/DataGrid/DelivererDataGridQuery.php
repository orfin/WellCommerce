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

namespace WellCommerce\Deliverer\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class DelivererDataGridQuery
 *
 * @package WellCommerce\Deliverer\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('deliverer');
        $qb->join('deliverer_translation', 'deliverer_translation.deliverer_id', '=', 'deliverer.id');
        $qb->groupBy('deliverer.id');

        return $qb;
    }
} 