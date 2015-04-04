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

/**
 * Class PackageDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'            => 'package.id',
            'name'          => 'package.name',
            'fullName'      => 'package.fullName',
            'vendor'        => 'package.vendor',
            'localVersion'  => 'package.localVersion',
            'remoteVersion' => 'package.remoteVersion',
            'createdAt'     => 'package.createdAt',
            'updatedAt'     => 'package.updatedAt',
        ]);
    }
}
