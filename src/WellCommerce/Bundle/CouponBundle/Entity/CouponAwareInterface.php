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


interface CouponAwareInterface
{
    public function setCoupon(CouponInterface $coupon);

    public function getCoupon() : CouponInterface;

    public function hasCoupon() : bool;

    public function removeCoupon();
}
