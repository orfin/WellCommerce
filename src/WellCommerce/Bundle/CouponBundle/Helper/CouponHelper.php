<?php

namespace WellCommerce\Bundle\CouponBundle\Helper;

use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;

/**
 * Class CouponHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponHelper
{
    public static function formatModifier(CouponInterface $coupon): string
    {
        if ($coupon->getModifierType() === '%') {
            return sprintf('-%s%s', $coupon->getModifierValue(), $coupon->getModifierType());
        }
        
        return sprintf('-%s%s', $coupon->getModifierValue(), $coupon->getCurrency());
    }
}