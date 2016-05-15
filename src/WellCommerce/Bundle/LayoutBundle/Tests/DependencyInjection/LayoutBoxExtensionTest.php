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

namespace WellCommerce\Bundle\LayoutBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class LayoutBoxExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'layout_box.repository',
                    'layout_box.factory',
                    'layout_box.manager',
                    'layout_box.form_builder.admin',
                    'layout_box.dataset.admin',
                    'layout_box.datagrid',
                    'layout_box.controller.admin',
                ]
            ],
        ];
    }
}
