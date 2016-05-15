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

namespace WellCommerce\Bundle\NewsBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class NewsExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'news.repository',
                    'news.factory',
                    'news.manager',
                    'news.form_builder.admin',
                    'news.dataset.admin',
                    'news.datagrid',
                    'news.controller.admin',
                ]
            ],
        ];
    }
}
