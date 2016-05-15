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

namespace WellCommerce\Bundle\AvailabilityBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class AvailabilityExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'availability.repository',
                    'availability.factory',
                    'availability.manager',
                    'availability.form_builder.admin',
                    'availability.dataset.admin',
                    'availability.datagrid',
                    'availability.controller.admin',
                ]
            ],
        ];
    }
}
