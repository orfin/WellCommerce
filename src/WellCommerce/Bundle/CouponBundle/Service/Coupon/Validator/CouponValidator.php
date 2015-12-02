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

namespace WellCommerce\Bundle\CouponBundle\Service\Coupon\Validator;

use WellCommerce\Bundle\AppBundle\Entity\CouponInterface;

/**
 * Class CouponValidator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponValidator
{
    /**
     * @var CouponInterface
     */
    protected $coupon;

    /**
     * @var string
     */
    protected $error = '';

    /**
     * @param CouponInterface $coupon
     */
    public function __construct(CouponInterface $coupon = null)
    {
        $this->coupon = $coupon;
    }

    /**
     * Checks whether the coupon is valid for use
     *
     * @return bool
     */
    public function isValid()
    {
        if (null === $this->coupon) {
            $this->error = 'coupon.error.not_found';

            return false;
        }

        if (false === $this->isStartDateValid()) {
            $this->error = 'coupon.error.future_coupon';

            return false;
        }

        if (false === $this->isNotExpired()) {
            $this->error = 'coupon.error.coupon_expired';

            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Checks whether the coupon's start date is valid
     *
     * @return bool
     */
    protected function isStartDateValid()
    {
        $now             = new \DateTime();
        $couponStartDate = $this->coupon->getValidFrom();

        if ($couponStartDate instanceof \DateTime) {
            return $now >= $couponStartDate;
        }

        return true;
    }

    /**
     * Checks whether the coupon is not expired
     *
     * @return bool
     */
    protected function isNotExpired()
    {
        $now           = new \DateTime();
        $couponEndDate = $this->coupon->getValidTo();

        if ($couponEndDate instanceof \DateTime) {
            return $now <= $couponEndDate;
        }

        return true;
    }
}
