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

namespace WellCommerce\Bundle\ProductStatusBundle\DataSet\Front;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatus;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusTranslation;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

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

        $configurator->setColumnTransformers([
            'route' => $this->getDataSetTransformer('route')
        ]);

        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            ProductStatus::class,
            ProductStatusTranslation::class
        ]));
    }
}
