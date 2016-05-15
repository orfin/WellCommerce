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

namespace WellCommerce\Bundle\CategoryBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class CategoryExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'category.repository',
                    'category.factory',
                    'category.manager',
                    'category.form_builder.admin',
                    'category.dataset.admin',
                    'category.controller.admin',
                ]
            ],
        ];
    }
}
