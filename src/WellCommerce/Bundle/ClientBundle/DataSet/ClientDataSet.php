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

namespace WellCommerce\Bundle\ClientBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\DateTransformer;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\TransformerCollection;

/**
 * Class ClientDataSet
 *
 * @package WellCommerce\Bundle\ClientBundle\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'client.id',
        ]));

        $collection->add(new Column([
            'alias'  => 'firstName',
            'source' => 'client.firstName',
        ]));

        $collection->add(new Column([
            'alias'  => 'lastName',
            'source' => 'client.lastName',
        ]));

        $collection->add(new Column([
            'alias'  => 'email',
            'source' => 'client.email',
        ]));

        $collection->add(new Column([
            'alias'  => 'phone',
            'source' => 'client.phone',
        ]));

        $collection->add(new Column([
            'alias'            => 'createdAt',
            'source'           => 'client.createdAt',
        ]));
    }

    protected function configureTransformers(TransformerCollection $collection)
    {
        $collection->add('createdAt', new DateTransformer('Y-m-d H:i:s'));
    }
}