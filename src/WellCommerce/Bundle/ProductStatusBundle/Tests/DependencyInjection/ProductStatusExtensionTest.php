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

namespace WellCommerce\Bundle\ProductStatusBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class ProductStatusExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'product_status.repository',
                    'product_status.factory',
                    'product_status.manager',
                    'product_status.form_builder.admin',
                    'product_status.dataset.admin',
                    'product_status.dataset.front',
                    'product_status.datagrid',
                    'product_status.controller.admin',
                    'product_status.controller.front',
                ]
            ],
        ];
    }
}
