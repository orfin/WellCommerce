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

namespace WellCommerce\Bundle\CurrencyBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class CurrencyExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'currency.repository',
                    'currency.factory',
                    'currency.manager',
                    'currency.form_builder.admin',
                    'currency.dataset.admin',
                    'currency.dataset.front',
                    'currency.datagrid',
                    'currency.controller.admin',
                    'currency.controller.front',
                ]
            ],
        ];
    }
}
