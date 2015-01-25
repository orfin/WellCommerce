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

namespace WellCommerce\Bundle\ClientBundle\DataSet;

use WellCommerce\Bundle\DataSetBundle\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\DataSetConfiguratorInterface;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;

/**
 * Class ClientGroupDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'           => 'client_group.id',
            'name'         => 'client_group_translation.name',
            'totalClients' => 'COUNT(client)',
        ]);
    }
}
