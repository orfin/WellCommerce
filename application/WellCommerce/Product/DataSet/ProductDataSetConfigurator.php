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

namespace WellCommerce\Product\DataSet;

use WellCommerce\Core\DataSet\Configurator\AbstractConfigurator;
use WellCommerce\Core\DataSet\Configurator\ConfiguratorInterface;
use WellCommerce\Core\DataSet\DataSetInterface;

/**
 * Class ProductDataSetConfigurator
 *
 * @package WellCommerce\Product\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSetConfigurator extends AbstractConfigurator implements ConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(DataSetInterface $datagrid)
    {
        $datagrid->setIdentifier($this->identifier);

        $datagrid->setColumns($this->columns);

        $datagrid->setQueryBuilder($this->queryBuilder);
    }
}