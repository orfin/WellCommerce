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
            'id'     => 'id',
            'source' => 'client.id',
        ]));

        $collection->add(new Column([
            'id'     => 'firstName',
            'source' => 'client.firstName',
        ]));

        $collection->add(new Column([
            'id'     => 'lastName',
            'source' => 'client.lastName',
        ]));

        $collection->add(new Column([
            'id'     => 'email',
            'source' => 'client.email',
        ]));

        $collection->add(new Column([
            'id'     => 'phone',
            'source' => 'client.phone',
        ]));

        $collection->add(new Column([
            'id'               => 'createdAt',
            'source'           => 'client.createdAt',
            'process_function' => function (\DateTime $createdAt) {
                return $createdAt->format('Y-m-d H:i:s');
            }
        ]));
    }

    protected function configureProcessors()
    {
        return [
            'createdAt' => new DateTransformer()
        ];
    }
}