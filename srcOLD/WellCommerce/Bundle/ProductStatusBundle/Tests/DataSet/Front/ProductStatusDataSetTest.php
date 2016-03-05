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

namespace WellCommerce\Bundle\ProductStatusBundle\Tests\DataSet\Front;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class ProductStatusDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('product_status.dataset.front');
    }

    protected function getColumns()
    {
        return [
            'id'        => 'product_status.id',
            'name'      => 'product_status_translation.name',
            'route'     => 'IDENTITY(product_status_translation.route)',
            'css_class' => 'product_status_translation.cssClass',
        ];
    }
}
