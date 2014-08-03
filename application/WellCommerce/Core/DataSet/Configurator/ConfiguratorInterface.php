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

namespace WellCommerce\Core\DataSet\Configurator;

use WellCommerce\Core\DataSet\DataSetInterface;

/**
 * Interface ConfiguratorInterface
 *
 * @package WellCommerce\Core\DataGrid\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ConfiguratorInterface
{
    /**
     * Configures the dataset
     *
     * @param DataSetInterface $dataset
     *
     * @return mixed
     */
    public function configure(DataSetInterface $dataset);
} 