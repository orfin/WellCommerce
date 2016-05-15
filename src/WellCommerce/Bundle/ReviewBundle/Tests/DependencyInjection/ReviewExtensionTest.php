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

namespace WellCommerce\Bundle\ReviewBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class ReviewExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'review.repository',
                    'review.factory',
                    'review.manager',
                    'review.form_builder.admin',
                    'review.dataset.admin',
                    'review.datagrid',
                    'review.controller.admin',
                ]
            ],
        ];
    }
}
