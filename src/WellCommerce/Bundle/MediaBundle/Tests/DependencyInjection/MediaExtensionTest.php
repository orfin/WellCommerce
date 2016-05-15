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

namespace WellCommerce\Bundle\MediaBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class MediaExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'media.repository',
                    'media.factory',
                    'media.manager',
                    'media.form_builder.admin',
                    'media.dataset.admin',
                    'media.datagrid',
                    'media.controller.admin'
                ]
            ],
        ];
    }
}
