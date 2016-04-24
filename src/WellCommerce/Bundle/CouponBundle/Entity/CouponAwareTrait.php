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

namespace WellCommerce\Bundle\CouponBundle\Entity;

/**
 * Trait CouponAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait CouponAwareTrait
{
    protected $coupon;

    public function getCoupon() : CouponInterface
    {
        return $this->coupon;
    }

    public function setCoupon(CouponInterface $coupon)
    {
        $this->coupon = $coupon;
    }

    public function hasCoupon() : bool
    {
        return $this->coupon instanceof CouponInterface;
    }

    public function removeCoupon()
    {
        $this->coupon = null;
    }
}
