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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;

/**
 * Class CouponFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = CouponInterface::class;

    /**
     * @return CouponInterface
     */
    public function create()
    {
        /** @var $coupon CouponInterface */
        $coupon = $this->init();
        $coupon->setClientUsageLimit(1);
        $coupon->setGlobalUsageLimit(1);
        $coupon->setModifierType('%');
        $coupon->setModifierValue(100);

        return $coupon;
    }
}
