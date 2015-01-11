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
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetOptionsResolver;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\DateTransformer;

/**
 * Class ClientDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(DataSetOptionsResolver $resolver)
    {
        $resolver->setColumns([
            'id'        => 'client.id',
            'firstName' => 'client.firstName',
            'lastName'  => 'client.lastName',
            'email'     => 'client.email',
            'phone'     => 'client.phone',
            'createdAt' => 'client.createdAt',
        ]);

        $resolver->setTransformers([
            'createdAt' => new DateTransformer('Y-m-d H:i:s')
        ]);
    }
}