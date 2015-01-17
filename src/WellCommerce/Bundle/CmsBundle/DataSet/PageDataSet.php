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

namespace WellCommerce\Bundle\CmsBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetConfiguratorInterface;

/**
 * Class PageDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'page.id',
            'parent'    => 'IDENTITY(page.parent)',
            'children'  => 'COUNT(page_children.id)',
            'name'      => 'page_translation.name',
            'slug'      => 'page_translation.slug',
            'locale'    => 'page_translation.locale',
            'route'     => 'IDENTITY(page_translation.route)',
            'publish'   => 'page.publish',
            'hierarchy' => 'page.hierarchy',
        ]);
    }
}
