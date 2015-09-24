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

namespace WellCommerce\Bundle\ProductBundle\DataSet\Front;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\Configurator\DataSetConfiguratorInterface;

/**
 * Class ProductStatusDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'product_status.id',
            'name'      => 'product_status_translation.name',
            'route'     => 'IDENTITY(product_status_translation.route)',
            'css_class' => 'product_status_translation.cssClass',
        ]);

        $configurator->setTransformers([
            'route' => $this->container->get('route.transformer')
        ]);
    }
}
