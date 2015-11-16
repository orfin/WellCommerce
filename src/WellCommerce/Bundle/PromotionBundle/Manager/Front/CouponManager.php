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

namespace WellCommerce\Bundle\PromotionBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\PromotionBundle\Entity\CouponInterface;
use WellCommerce\Bundle\PromotionBundle\Exception\CouponException;
use WellCommerce\Bundle\PromotionBundle\Validator\CouponValidator;

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
     * @return null|\WellCommerce\Bundle\PromotionBundle\Entity\CouponInterface
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
        $cart = $this->getCartContext()->getCurrentCart();
        $cart->setCoupon($coupon);
        $this->updateResource($cart);
    }

    /**
     * Removes coupon from cart
     */
    public function removeCartCoupon()
    {
        $cart = $this->getCartContext()->getCurrentCart();
        $cart->setCoupon(null);
        $this->updateResource($cart);
    }
}
