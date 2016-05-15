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

namespace WellCommerce\Bundle\PageBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class PageExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'page.repository',
                    'page.factory',
                    'page.manager',
                    'page.form_builder.admin',
                    'page.dataset.admin',
                    'page.datagrid',
                    'page.controller.admin',
                    'page.controller.front',
                ]
            ],
        ];
    }
}
