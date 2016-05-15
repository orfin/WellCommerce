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

namespace WellCommerce\Bundle\ContactBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class ContactExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'contact.repository',
                    'contact.factory',
                    'contact.manager',
                    'contact.form_builder.admin',
                    'contact.dataset.admin',
                    'contact.datagrid',
                    'contact.controller.admin',
                ]
            ],
        ];
    }
}
