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

namespace WellCommerce\Bundle\CmsBundle\DataSet\Front;

use WellCommerce\Bundle\CmsBundle\DataSet\Admin\PageDataSet as BaseDataSet;
use WellCommerce\Bundle\DataSetBundle\Configurator\DataSetConfiguratorInterface;

/**
 * Class PageDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataSet extends BaseDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        parent::configureOptions($configurator);

        $configurator->setTransformers([
            'route' => $this->container->get('route.transformer')
        ]);
    }
}
