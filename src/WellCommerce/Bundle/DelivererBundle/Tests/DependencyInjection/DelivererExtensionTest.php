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

namespace WellCommerce\Bundle\DelivererBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class DelivererExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'deliverer.repository',
                    'deliverer.factory',
                    'deliverer.manager',
                    'deliverer.form_builder.admin',
                    'deliverer.dataset.admin',
                    'deliverer.datagrid',
                    'deliverer.controller.admin',
                ]
            ],
        ];
    }
}
