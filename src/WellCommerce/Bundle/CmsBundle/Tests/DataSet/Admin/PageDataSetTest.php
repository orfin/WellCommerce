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

namespace WellCommerce\Bundle\CmsBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class PageDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('page.dataset.admin');
    }

    protected function getColumns()
    {
        return [
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
        ];
    }
}
