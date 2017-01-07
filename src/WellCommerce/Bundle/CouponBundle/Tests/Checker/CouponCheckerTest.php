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

namespace WellCommerce\Bundle\CouponBundle\Tests\Checker;

use Carbon\Carbon;
use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\CouponBundle\Checker\CouponCheckerInterface;
use WellCommerce\Bundle\CouponBundle\Entity\Coupon;

/**
 * Class CouponCheckerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponCheckerTest extends AbstractTestCase
{
    public function testCouponNotFound()
    {
        $checker = $this->getCheckerService();
        $result  = $checker->isValid(null);
        $error   = $checker->getError();
        
        $this->assertFalse($result);
        $this->assertEquals('coupon.error.not_found', $error);
    }
    
    public function testStartDateValid()
    {
        $checker = $this->getCheckerService();
        $coupon  = new Coupon();
        
        $coupon->setValidFrom(Carbon::now());
        $this->assertTrue($checker->isStartDateValid($coupon));
        
        $coupon->setValidFrom(Carbon::now()->addMinute(1));
        $this->assertFalse($checker->isStartDateValid($coupon));
    }
    
    public function testNotExpired()
    {
        $checker = $this->getCheckerService();
        $coupon  = new Coupon();
        
        $coupon->setValidTo(Carbon::now());
        $this->assertTrue($checker->isNotExpired($coupon));
        
        $coupon->setValidTo(Carbon::now()->subMinute(1));
        $this->assertFalse($checker->isNotExpired($coupon));
        
        $coupon->setValidTo(Carbon::now()->addMinute(1));
        $this->assertTrue($checker->isNotExpired($coupon));
    }
    
    private function getCheckerService(): CouponCheckerInterface
    {
        return $this->container->get('coupon.checker');
    }
}