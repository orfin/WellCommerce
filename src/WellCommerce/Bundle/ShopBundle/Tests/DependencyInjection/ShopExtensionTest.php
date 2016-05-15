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

namespace WellCommerce\Bundle\ShopBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class ShopExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'shop.repository',
                    'shop.factory',
                    'shop.manager',
                    'shop.form_builder.admin',
                    'shop.dataset.admin',
                    'shop.datagrid',
                    'shop.controller.admin',
                ]
            ],
        ];
    }
}
