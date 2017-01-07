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

namespace WellCommerce\Bundle\CouponBundle\Checker;

use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;

/**
 * Interface CouponCheckerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CouponCheckerInterface
{
    public function isValid(CouponInterface $coupon): bool;
    
    public function getError(): string;
    
    public function isStartDateValid(CouponInterface $coupon): bool;
    
    public function isNotExpired(CouponInterface $coupon): bool;
}
