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

namespace WellCommerce\Bundle\OrderBundle\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class OrderDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'                => 'orders.id',
            'client'            => 'CONCAT_WS(\':\', orders.billingAddress.firstName, orders.billingAddress.lastName, orders.contactDetails.phone)',
            'productTotal'      => 'orders.productTotal.grossPrice',
            'orderTotal'        => 'orders.summary.grossAmount',
            'currentStatusId'   => 'IDENTITY(orders.currentStatus)',
            'currentStatusName' => 'status_translation.name',
            'currency'          => 'orders.currency',
            'createdAt'         => 'orders.createdAt',
        ]);

        $configurator->setColumnTransformers([
            'createdAt' => $this->getDataSetTransformer('date', ['format' => 'Y-m-d H:i:s']),
            'client'    => $this->getDataSetTransformer('order_client'),
        ]);
    }
}
