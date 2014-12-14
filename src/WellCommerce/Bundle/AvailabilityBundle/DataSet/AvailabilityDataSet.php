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

namespace WellCommerce\Bundle\AvailabilityBundle\DataSet;

use WellCommerce\Bundle\DataSetBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\DataSet\Column\Column;
use WellCommerce\Bundle\DataSetBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\DataSet\DataSetInterface;

/**
 * Class AvailabilityDataSet
 *
 * @package WellCommerce\Bundle\AvailabilityBundle\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'availability.id',
        ]));

        $collection->add(new Column([
            'alias'  => 'name',
            'source' => 'availability_translation.name',
        ]));
    }
}