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

namespace WellCommerce\Bundle\PageBundle\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

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
    public function configureOptions (DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'page.id',
            'createdAt' => 'page.createdAt',
            'parent'    => 'IDENTITY(page.parent)',
            'children'  => 'page_translation.name',
            'name'      => 'page_translation.name',
            'content'   => 'page_translation.content',
            'slug'      => 'page_translation.slug',
            'locale'    => 'page_translation.locale',
            'route'     => 'IDENTITY(page_translation.route)',
            'publish'   => 'page.publish',
            'section'   => 'page.section',
            'shop'      => 'page_shops.id',
            'hierarchy' => 'page.hierarchy',
        ]);
        
        $configurator->setColumnTransformers([
            'createdAt' => $this->getDataSetTransformer('date', ['format' => 'Y-m-d H:i:s']),
        ]);
    }
}
