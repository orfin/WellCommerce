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

use WellCommerce\Core\DataGrid\Configuration\Appearance;
use WellCommerce\Core\DataGrid\Configuration\Mechanics;
use WellCommerce\Core\DataGrid\Configurator\AbstractConfigurator;
use WellCommerce\Core\DataGrid\Configurator\ConfiguratorInterface;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class AvailabilityDataGridConfigurator
 *
 * @package WellCommerce\Availability\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDataGridConfigurator extends AbstractConfigurator implements ConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(DataGridInterface $datagrid)
    {
        $datagrid->setIdentifier('availability');

        $datagrid->setColumns($this->columns);

        $datagrid->setQuery($this->query);

        $this->options->setAppearance(new Appearance([
            'header' => false
        ]));

        $this->options->setMechanics(new Mechanics([
            'rows_per_page' => 500
        ]));

        $datagrid->setOptions($this->options);
    }
}