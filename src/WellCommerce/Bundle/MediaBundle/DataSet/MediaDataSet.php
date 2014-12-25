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
use WellCommerce\Bundle\CoreBundle\DataSet\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\TransformerCollection;
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
    protected function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'media.id'
        ]));

        $collection->add(new Column([
            'alias'  => 'name',
            'source' => 'media.name'
        ]));

        $collection->add(new Column([
            'alias'  => 'mime',
            'source' => 'media.mime'
        ]));

        $collection->add(new Column([
            'alias'  => 'extension',
            'source' => 'media.extension'
        ]));

        $collection->add(new Column([
            'alias'  => 'size',
            'source' => 'media.size'
        ]));

        $collection->add(new Column([
            'alias'  => 'preview',
            'source' => 'media.path'
        ]));
    }

    protected function configureTransformers(TransformerCollection $collection)
    {
        $collection->add('preview', new ImagePathTransformer($this->container->get('image_helper'), 'medium'));
    }
}