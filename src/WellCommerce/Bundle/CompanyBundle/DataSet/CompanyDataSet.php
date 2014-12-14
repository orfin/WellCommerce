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

namespace WellCommerce\Bundle\CompanyBundle\DataSet;

use WellCommerce\Bundle\DataSetBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\DataSet\Column\Column;
use WellCommerce\Bundle\DataSetBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\DataSet\DataSetInterface;


/**
 * Class CompanyDataSet
 *
 * @package WellCommerce\Bundle\CompanyBundle\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'company.id'
        ]));

        $collection->add(new Column([
            'alias'  => 'name',
            'source' => 'company.name'
        ]));

        $collection->add(new Column([
            'alias'  => 'shortName',
            'source' => 'company.shortName'
        ]));

        $collection->add(new Column([
            'alias'  => 'createdAt',
            'source' => 'company.createdAt',
        ]));
    }
}