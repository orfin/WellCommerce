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

namespace WellCommerce\Bundle\ProducerBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class ProducerExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'producer.repository',
                    'producer.factory',
                    'producer.manager',
                    'producer.form_builder.admin',
                    'producer.dataset.admin',
                    'producer.datagrid',
                    'producer.controller.admin',
                ]
            ],
        ];
    }
}
