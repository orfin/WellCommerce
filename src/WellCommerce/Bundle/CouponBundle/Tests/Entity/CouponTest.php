<?php
/**
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CouponBundle\Tests\Entity;

use Carbon\Carbon;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;
use WellCommerce\Bundle\CouponBundle\Entity\Coupon;

/**
 * Class CouponTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new Coupon();
    }
    
    public function providerTestAccessor()
    {
        $faker = $this->getFakerGenerator();
        
        return [
            ['code', $faker->randomDigit],
            ['currency', $faker->currencyCode],
            ['modifierType', '%'],
            ['modifierType', '-'],
            ['modifierValue', rand(0, 100)],
            ['clientUsageLimit', rand(0, 100)],
            ['globalUsageLimit', rand(0, 100)],
            ['minimumOrderValue', rand(0, 100)],
            ['validFrom', Carbon::now()],
            ['validFrom', null],
            ['validTo', Carbon::now()],
            ['validTo', null],
        ];
    }
}
