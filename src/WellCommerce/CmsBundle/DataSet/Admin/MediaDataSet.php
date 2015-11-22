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

namespace WellCommerce\CmsBundle\DataSet\Admin;

use WellCommerce\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class MediaDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'media.id',
            'name'      => 'media.name',
            'mime'      => 'media.mime',
            'extension' => 'media.extension',
            'size'      => 'media.size',
            'preview'   => 'media.path',
        ]);

        $configurator->setColumnTransformers([
            'preview' => $this->getDataSetTransformer('image_path', ['filter' => 'medium'])
        ]);
    }
}
