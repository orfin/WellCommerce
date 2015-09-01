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

namespace WellCommerce\Bundle\OrderBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;
use WellCommerce\Bundle\DataSetBundle\Transformer\DateTransformer;

/**
 * Class OrderStatusGroupDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusGroupDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'order_status_group.id',
            'name'      => 'order_status_group_translation.name',
            'createdAt' => 'order_status_group.createdAt',
        ]);

        $configurator->setTransformers([
            'createdAt' => new DateTransformer('Y-m-d H:i:s'),
        ]);
    }
}
