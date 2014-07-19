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
use WellCommerce\Core\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\Component\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\Component\DataGrid\Column\DataGridColumn;
use WellCommerce\Core\Component\DataGrid\Configuration\Appearance;
use WellCommerce\Core\Component\DataGrid\Configuration\EventHandlers;
use WellCommerce\Core\Component\DataGrid\Configuration\Mechanics;

/**
 * Class Configuration
 *
 * @package WellCommerce\Availability\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Configuration extends AbstractDataGridConfiguration
{
    protected $id = 'availability';

    public function getId()
    {
        return $this->id;
    }

    public function getAppearance()
    {
        return new Appearance();
    }

    public function getMechanics()
    {
        return new Mechanics();
    }

    public function getEventHandlers()
    {
        return new EventHandlers();
    }

    public function getQuery(Manager $manager)
    {
        $query = $manager->table('availability');
        $query->join('availability_translation', 'availability_translation.availability_id', '=', 'availability.id');
        $query->groupBy('availability.id');

        return $query;
    }
} 