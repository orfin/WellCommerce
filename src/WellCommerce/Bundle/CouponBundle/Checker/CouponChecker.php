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
use WellCommerce\Bundle\OrderBundle\Repository\OrderRepositoryInterface;

/**
 * Class CouponChecker
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponChecker implements CouponCheckerInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var string
     */
    protected $error = '';

    /**
     * CouponChecker constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(CouponInterface $coupon = null)
    {
        if (null === $coupon) {
            $this->error = 'coupon.error.not_found';

            return false;
        }

        if (false === $this->isStartDateValid($coupon)) {
            $this->error = 'coupon.error.future_coupon';

            return false;
        }

        if (false === $this->isNotExpired($coupon)) {
            $this->error = 'coupon.error.coupon_expired';

            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
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
    protected function isStartDateValid(CouponInterface $coupon)
    {
        $now             = new \DateTime();
        $couponStartDate = $coupon->getValidFrom();

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
    protected function isNotExpired(CouponInterface $coupon)
    {
        $now           = new \DateTime();
        $couponEndDate = $coupon->getValidTo();

        if ($couponEndDate instanceof \DateTime) {
            return $now <= $couponEndDate;
        }

        return true;
    }
}
