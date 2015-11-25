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

namespace WellCommerce\AppBundle\DataSet\Admin;

use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\CoreBundle\DataSet\AbstractDataSet;

/**
 * Class PageDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'page.id',
            'parent'    => 'IDENTITY(page.parent)',
            'children'  => 'page_translation.name',
            'name'      => 'page_translation.name',
            'slug'      => 'page_translation.slug',
            'locale'    => 'page_translation.locale',
            'route'     => 'IDENTITY(page_translation.route)',
            'publish'   => 'page.publish',
            'shop'      => 'page_shops.id',
            'hierarchy' => 'page.hierarchy',
        ]);
    }
}
