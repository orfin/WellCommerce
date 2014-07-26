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

namespace WellCommerce\Unit\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class UnitDataGridQuery
 *
 * @package WellCommerce\Unit\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('unit');
        $qb->join('unit_translation', 'unit_translation.unit_id', '=', 'unit.id');
        $qb->groupBy('unit.id');

        return $qb;
    }
} 