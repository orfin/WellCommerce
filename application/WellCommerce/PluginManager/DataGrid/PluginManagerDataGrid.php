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
namespace WellCommerce\PluginManager\DataGrid;

use WellCommerce\Core\DataGrid,
    WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class PluginManagerDataGrid
 *
 * @package WellCommerce\PluginManager\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PluginManagerDataGrid extends DataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setTableData([
            'id'   => [
                'source' => 'C.id'
            ],
            'name' => [
                'source' => 'C.name'
            ],
        ]);

        $this->setFrom('
            plugin_manager C
        ');

        $this->setGroupBy('
            C.id
        ');
    }

    /**
     * {@inheritdoc}
     */
    public function registerEventHandlers()
    {
        $this->getXajaxManager()->registerFunctions([
            'getPluginManagerForAjax' => [$this, 'getData'],
            'doDeletePluginManager'   => [$this, 'delete']
        ]);
    }
}