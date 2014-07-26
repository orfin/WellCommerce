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

namespace WellCommerce\Availability\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class AvailabilityDataGridQuery
 *
 * @package WellCommerce\Availability\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('availability');
        $qb->join('availability_translation', 'availability_translation.availability_id', '=', 'availability.id');
        $qb->groupBy('availability.id');

        return $qb;
    }
} 