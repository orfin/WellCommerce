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

namespace WellCommerce\Bundle\ProducerBundle\DataSet\Front;

use WellCommerce\Bundle\ProducerBundle\DataSet\Admin\ProducerDataSet as BaseDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class ProducerDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerDataSet extends BaseDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'       => 'producer.id',
            'name'     => 'producer_translation.name',
            'route'    => 'IDENTITY(producer_translation.route)',
            'products' => 'COUNT(producer_products.id)',
        ]);

        $configurator->setColumnTransformers([
            'route' => $this->getDataSetTransformer('route')
        ]);
    }
}
