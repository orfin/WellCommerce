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

namespace WellCommerce\Bundle\LocaleBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class LocaleExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'locale.repository',
                    'locale.factory',
                    'locale.manager',
                    'locale.form_builder.admin',
                    'locale.dataset.admin',
                    'locale.dataset.front',
                    'locale.datagrid',
                    'locale.controller.admin',
                    'locale.controller.front',
                    'locale.copier',
                ]
            ],
        ];
    }
}
