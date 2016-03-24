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
    /**
     * Checks whether the coupon is valid for use
     *
     * @return bool
     */
    public function isValid(CouponInterface $coupon) : bool;

    /**
     * @return string
     */
    public function getError() : string;
}
