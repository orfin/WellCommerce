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

namespace WellCommerce\Bundle\LayoutBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;

/**
 * Class LayoutBoxDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'layout_box.id',
        ]));

        $collection->add(new Column([
            'alias'  => 'name',
            'source' => 'layout_box_translation.name',
        ]));

        $collection->add(new Column([
            'alias'  => 'identifier',
            'source' => 'layout_box.identifier',
        ]));

        $collection->add(new Column([
            'alias'  => 'boxType',
            'source' => 'layout_box.boxType',
        ]));
    }
}