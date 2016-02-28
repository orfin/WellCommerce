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

namespace WellCommerce\Bundle\LayoutBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class LayoutBoxDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('layout_box.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'         => 'layout_box.id',
            'name'       => 'layout_box_translation.name',
            'identifier' => 'layout_box.identifier',
            'boxType'    => 'layout_box.boxType',
        ];
    }
}
