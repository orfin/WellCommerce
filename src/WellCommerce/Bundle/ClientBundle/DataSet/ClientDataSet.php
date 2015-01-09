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
        foreach ($this->getColumnMappings() as $alias => $source) {
            $collection->add(new Column([
                'alias'  => $alias,
                'source' => $source,
            ]));
        }
    }

    /**
     * Returns column mappings
     *
     * @return array
     */
    protected function getColumnMappings()
    {
        return [
            'id'        => 'client.id',
            'firstName' => 'client.firstName',
            'email'     => 'client.email',
            'phone'     => 'client.phone',
            'createdAt' => 'client.createdAt',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function configureTransformers(TransformerCollection $collection)
    {
        $collection->add('createdAt', new DateTransformer('Y-m-d H:i:s'));
    }
}