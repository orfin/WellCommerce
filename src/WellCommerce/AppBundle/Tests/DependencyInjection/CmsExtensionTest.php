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

namespace WellCommerce\AppBundle\Tests\DependencyInjection;

use WellCommerce\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class CmsExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CmsExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    // contact services
                    'contact.repository',
                    'contact.factory',
                    'contact.event_dispatcher',
                    'contact.form_builder.admin',
                    'contact.dataset.admin',
                    'contact.datagrid',
                    'contact.controller.admin',
                    // news services
                    'news.repository',
                    'news.factory',
                    'news.event_dispatcher',
                    'news.form_builder.admin',
                    'news.dataset.admin',
                    'news.datagrid',
                    'news.controller.admin',
                    // page services
                    'page.repository',
                    'page.factory',
                    'page.event_dispatcher',
                    'page.form_builder.admin',
                    'page.dataset.admin',
                    'page.datagrid',
                    'page.controller.admin',
                    'page.controller.front',
                    // media services
                    'media.repository',
                    'media.factory',
                    'media.event_dispatcher',
                    'media.form_builder.admin',
                    'media.dataset.admin',
                    'media.datagrid',
                    'media.controller.admin'
                ]
            ],
        ];
    }
}
