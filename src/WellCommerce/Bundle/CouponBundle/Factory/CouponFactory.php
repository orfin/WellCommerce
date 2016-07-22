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

namespace WellCommerce\Bundle\CouponBundle\Factory;

use WellCommerce\Bundle\CouponBundle\Entity\Coupon;
use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CouponFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponFactory extends AbstractEntityFactory
{
    public function create() : CouponInterface
    {
        $coupon = new Coupon();
        $coupon->setClientUsageLimit(1);
        $coupon->setGlobalUsageLimit(1);
        $coupon->setModifierType('%');
        $coupon->setModifierValue(100);
        $coupon->setCode(strtoupper(uniqid()));
        $coupon->setCurrency('');
        
        return $coupon;
    }
}
