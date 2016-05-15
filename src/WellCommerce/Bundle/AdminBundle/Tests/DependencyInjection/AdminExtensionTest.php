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

namespace WellCommerce\Bundle\AdminBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class AdminExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    // user
                    'user.repository',
                    'user.factory',
                    'user.manager',
                    'user.form_builder.admin',
                    'user.dataset.admin',
                    'user.datagrid',
                    'user.controller.admin',
                    // user group
                    'user_group.repository',
                    'user_group.factory',
                    'user_group.manager',
                    'user_group.form_builder.admin',
                    'user_group.dataset.admin',
                    'user_group.datagrid',
                    'user_group.controller.admin',
                ]
            ],
        ];
    }
}
