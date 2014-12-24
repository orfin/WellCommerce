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

namespace WellCommerce\Bundle\TaxBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;

/**
 * Class TaxDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'tax.id'
        ]));

        $collection->add(new Column([
            'alias'  => 'name',
            'source' => 'tax_translation.name'
        ]));

        $collection->add(new Column([
            'alias'  => 'value',
            'source' => 'tax.value'
        ]));
    }
}