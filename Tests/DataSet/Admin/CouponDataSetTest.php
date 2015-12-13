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

namespace WellCommerce\Bundle\CouponBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class CouponDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('coupon.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'        => 'coupon.id',
            'name'      => 'coupon_translation.name',
            'code'      => 'coupon.code',
            'createdAt' => 'coupon.createdAt',
            'validFrom' => 'coupon.validFrom',
            'validTo'   => 'coupon.validTo',
            'discount'  => 'IF_ELSE(coupon.modifierType = \'%\', CONCAT_WS(\'\', coupon.modifierValue, coupon.modifierType), CONCAT_WS(\' \', coupon.modifierValue, coupon.currency))',
        ];
    }
}
