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
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetOptionsResolver;

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
    protected function configureOptions(DataSetOptionsResolver $resolver)
    {
        $resolver->setColumns([
            'id'    => 'tax.id',
            'name'  => 'tax_translation.name',
            'value' => 'tax.value'
        ]);
    }
}