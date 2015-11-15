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

namespace WellCommerce\Bundle\CatalogBundle\Tests\DataSet\Front;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class ProducerDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('producer.dataset.front');
    }

    protected function getColumns()
    {
        return [
            'id'       => 'producer.id',
            'name'     => 'producer_translation.name',
            'route'    => 'IDENTITY(producer_translation.route)',
            'products' => 'COUNT(producer_products.id)',
        ];
    }
}
