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

namespace WellCommerce\Bundle\SmugglerBundle\DataSet;

use WellCommerce\Bundle\DataSetBundle\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\DataSetConfiguratorInterface;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;
use WellCommerce\Bundle\DataSetBundle\Transformer\DateTransformer;

/**
 * Class ChannelDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ChannelDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'channel.id',
            'name'      => 'channel.name',
            'url'       => 'channel.url',
            'createdAt' => 'channel.createdAt',
            'updatedAt' => 'channel.updatedAt',
        ]);

        $configurator->setTransformers([
            'createdAt' => new DateTransformer('Y-m-d H:i:s'),
            'updatedAt' => new DateTransformer('Y-m-d H:i:s'),
        ]);
    }
}
