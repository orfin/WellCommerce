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

namespace WellCommerce\Bundle\ClientBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class ClientExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'client.repository',
                    'client.factory',
                    'client.event_dispatcher',
                    'client.form_builder.admin',
                    'client.dataset.admin',
                    'client.datagrid',
                    'client.controller.admin',
                ]
            ],
        ];
    }
}
