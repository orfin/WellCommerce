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

namespace WellCommerce\Bundle\CategoryBundle\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\ShopBundle\Storage\ShopStorageInterface;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class CategoryDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class CategoryDataSet extends AbstractDataSet
{
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'category.id',
            'hierarchy' => 'category.hierarchy',
            'enabled'   => 'category.enabled',
            'parent'    => 'IDENTITY(category.parent)',
            'children'  => 'COUNT(category_children.id)',
            'products'  => 'COUNT(category_products.id)',
            'name'      => 'category_translation.name',
            'slug'      => 'category_translation.slug',
            'shop'      => 'category_shops.id',
            'route'     => 'IDENTITY(category_translation.route)',
        ]);
    }
}
