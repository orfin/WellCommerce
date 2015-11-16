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

namespace WellCommerce\Bundle\CatalogBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class DelivererDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('deliverer.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'   => 'deliverer.id',
            'name' => 'deliverer_translation.name',
        ];
    }
}
