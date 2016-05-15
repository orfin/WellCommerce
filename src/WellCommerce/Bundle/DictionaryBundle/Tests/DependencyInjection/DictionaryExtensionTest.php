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

namespace WellCommerce\Bundle\DictionaryBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class DictionaryExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'dictionary.repository',
                    'dictionary.factory',
                    'dictionary.manager',
                    'dictionary.form_builder.admin',
                    'dictionary.dataset.admin',
                    'dictionary.datagrid',
                    'dictionary.controller.admin',
                ]
            ],
        ];
    }
}
