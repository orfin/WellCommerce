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

namespace WellCommerce\Bundle\CouponBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class CouponExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'coupon.repository',
                    'coupon.factory',
                    'coupon.manager',
                    'coupon.form_builder.admin',
                    'coupon.dataset.admin',
                    'coupon.datagrid',
                    'coupon.controller.admin',
                ]
            ],
        ];
    }
}
