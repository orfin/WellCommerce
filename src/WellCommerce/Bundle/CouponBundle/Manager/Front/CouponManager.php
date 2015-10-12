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

namespace WellCommerce\Bundle\CouponBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;
use WellCommerce\Bundle\CouponBundle\Exception\CouponException;
use WellCommerce\Bundle\CouponBundle\Validator\CouponValidator;

/**
 * Class CouponManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponManager extends AbstractFrontManager
{
    /**
     * Use coupon on cart
     *
     * @param string $code
     *
     * @return bool
     */
    public function useCoupon($code)
    {
        $coupon    = $this->findCoupon($code);
        $validator = new CouponValidator($coupon);

        if (!$validator->isValid()) {
            throw new CouponException($validator->getError());
        }

        $this->applyCartCoupon($coupon);

        return true;
    }

    /**
     * Returns coupon object or null if not found
     *
     * @param string $code
     *
     * @return null|\WellCommerce\Bundle\CouponBundle\Entity\CouponInterface
     */
    protected function findCoupon($code)
    {
        return $this->repository->findOneBy([
            'code' => $code
        ]);
    }

    /**
     * Applies coupon on cart
     *
     * @param CouponInterface $coupon
     */
    protected function applyCartCoupon(CouponInterface $coupon)
    {
        $cart = $this->getCartProvider()->getCurrentCart();
        $cart->setCoupon($coupon);
        $this->updateResource($cart);
    }

    /**
     * Removes coupon from cart
     */
    public function removeCartCoupon()
    {
        $cart = $this->getCartProvider()->getCurrentCart();
        $cart->setCoupon(null);
        $this->updateResource($cart);
    }
}
