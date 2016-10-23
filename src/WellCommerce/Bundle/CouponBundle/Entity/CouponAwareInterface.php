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
 * Interface CouponAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CouponAwareInterface
{
    /**
     * @param CouponInterface $coupon
     *
     * @return mixed
     */
    public function setCoupon(CouponInterface $coupon);
    
    /**
     * @return CouponInterface|null
     */
    public function getCoupon();
    
    /**
     * @return bool
     */
    public function hasCoupon() : bool;
    
    /**
     * @return void
     */
    public function removeCoupon();
}
