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

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Bundle\DataSetBundle\Transformer\DateTransformer;
use WellCommerce\Bundle\SmugglerBundle\DataSet\Transformer\VersionReferenceTransformer;

/**
 * Class PackageDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageDataSet extends AbstractDataSet
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

        $configurator->setTransformers([
            'createdAt'     => new DateTransformer('Y-m-d H:i:s'),
            'updatedAt'     => new DateTransformer('Y-m-d H:i:s'),
            'localVersion'  => new VersionReferenceTransformer(),
            'remoteVersion' => new VersionReferenceTransformer(),
        ]);
    }
}
