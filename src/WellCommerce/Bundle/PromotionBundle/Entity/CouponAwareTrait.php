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

namespace WellCommerce\Bundle\PromotionBundle\Entity;

/**
 * Trait CouponAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait CouponAwareTrait
{
    /**
     * @var CouponInterface|null $coupon
     */
    protected $coupon;

    /**
     * @param CouponInterface|null $coupon
     */
    public function setCoupon(CouponInterface $coupon = null)
    {
        $this->coupon = $coupon;
    }

    /**
     * @return CouponInterface|null
     */
    public function getCoupon()
    {
        return $this->coupon;
    }
}
