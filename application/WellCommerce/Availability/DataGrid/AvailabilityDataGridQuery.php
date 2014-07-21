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

use WellCommerce\Core\DataGrid\Query\AbstractQuery;
use WellCommerce\Core\DataGrid\Query\QueryInterface;

/**
 * Class AvailabilityDataGridQuery
 *
 * @package WellCommerce\Availability\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDataGridQuery extends AbstractQuery implements QueryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $query = $this->getManager()->table('availability');
        $query->join('availability_translation', 'availability_translation.availability_id', '=', 'availability.id');
        $query->groupBy('availability.id');

        return $query;
    }
} 