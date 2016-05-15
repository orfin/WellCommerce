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

namespace WellCommerce\Bundle\UnitBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class UnitExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'unit.repository',
                    'unit.factory',
                    'unit.manager',
                    'unit.form_builder.admin',
                    'unit.dataset.admin',
                    'unit.datagrid',
                    'unit.controller.admin',
                ]
            ],
        ];
    }
}
