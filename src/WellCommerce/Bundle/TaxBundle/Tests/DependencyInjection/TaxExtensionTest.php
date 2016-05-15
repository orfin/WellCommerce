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

namespace WellCommerce\Bundle\TaxBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class TaxExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'tax.repository',
                    'tax.factory',
                    'tax.manager',
                    'tax.form_builder.admin',
                    'tax.dataset.admin',
                    'tax.datagrid',
                    'tax.controller.admin',
                ]
            ],
        ];
    }
}
