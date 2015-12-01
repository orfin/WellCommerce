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

namespace WellCommerce\Bundle\AppBundle\DataSet\Admin;

use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;

/**
 * Class ClientDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'client.id',
            'firstName' => 'client.contactDetails.firstName',
            'lastName'  => 'client.contactDetails.lastName',
            'email'     => 'client.contactDetails.email',
            'phone'     => 'client.contactDetails.phone',
            'groupName' => 'client_group_translation.name',
            'createdAt' => 'client.createdAt',
        ]);

        $configurator->setColumnTransformers([
            'createdAt' => $this->getDataSetTransformer('date', ['format' => 'Y-m-d H:i:s'])
        ]);
    }
}
