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

namespace WellCommerce\Bundle\DataGridBundle\Configurator;

/**
 * Interface ConfiguratorInterface
 *
 * @package WellCommerce\Bundle\DataGridBundle\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ConfiguratorInterface
{
    /**
     * Configures DataGrid
     *
     * @param DataGridInterface $datagrid
     *
     * @return mixed
     */
    public function configure(DataGridInterface $datagrid);
} 