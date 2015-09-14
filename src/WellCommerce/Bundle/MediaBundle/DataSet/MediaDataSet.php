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

namespace WellCommerce\Bundle\MediaBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;
use WellCommerce\Bundle\DataSetBundle\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Bundle\MediaBundle\DataSet\Transformer\ImagePathTransformer;

/**
 * Class MediaDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaDataSet extends AbstractDataSet
{
    /**
     * @var ImageHelperInterface
     */
    protected $imageHelper;

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

        $configurator->setTransformers([
            'preview' => new ImagePathTransformer($this->imageHelper, 'medium'),
        ]);
    }

    /**
     * Sets image helper
     *
     * @param ImageHelperInterface $imageHelper
     */
    public function setImageHelper(ImageHelperInterface $imageHelper)
    {
        $this->imageHelper = $imageHelper;
    }
}
