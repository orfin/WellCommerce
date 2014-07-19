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

use Illuminate\Database\Capsule\Manager;

/**
 * Class Query
 *
 * @package WellCommerce\Availability\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Query
{
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function getQuery()
    {
        $query = $this->getManager()->table('availability');
        $query->join('availability_translation', 'availability_translation.availability_id', '=', 'availability.id');
        $query->groupBy('availability.id');

        return $query;
    }
} 