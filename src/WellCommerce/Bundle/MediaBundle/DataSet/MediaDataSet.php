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
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetOptionsResolver;
use WellCommerce\Bundle\MediaBundle\DataSet\Transformer\ImagePathTransformer;

/**
 * Class MediaDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(DataSetOptionsResolver $resolver)
    {
        $resolver->setColumns([
            'id'        => 'media.id',
            'name'      => 'media.name',
            'mime'      => 'media.mime',
            'extension' => 'media.extension',
            'size'      => 'media.size',
            'preview'   => 'media.path',
        ]);

        $resolver->setTransformers([
            'preview' => new ImagePathTransformer($this->container->get('image_helper'), 'medium')
        ]);
    }
}