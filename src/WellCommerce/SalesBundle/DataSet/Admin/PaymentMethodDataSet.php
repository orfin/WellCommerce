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

namespace WellCommerce\SalesBundle\DataSet\Admin;

use WellCommerce\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class PaymentMethodDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'payment_method.id',
            'name'      => 'payment_method_translation.name',
            'processor' => 'payment_method.processor',
        ]);
    }
}
