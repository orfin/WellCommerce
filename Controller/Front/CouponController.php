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

namespace WellCommerce\Bundle\CouponBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;
use WellCommerce\Bundle\CouponBundle\Exception\CouponException;

/**
 * Class CouponController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponController extends AbstractFrontController
{
    /**
     * @var \WellCommerce\Bundle\CouponBundle\Manager\Front\CouponManager
     */
    protected $manager;

    /**
     * Adds a coupon to cart
     *
     * @param CouponInterface|null $coupon
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction(CouponInterface $coupon = null)
    {
        try {
            $this->manager->useCoupon($coupon);

            $result = [
                'success' => true
            ];
        } catch (CouponException $e) {
            $result = [
                'error'   => $this->trans('coupon.error'),
                'message' => $this->trans($e->getMessage()),
            ];
        }

        return $this->jsonResponse($result);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('cart.front.index');
        }

        try {
            $this->manager->removeCartCoupon();

            $result = [
                'success' => true
            ];
        } catch (CouponException $e) {
            $result = [
                'error'   => $this->trans('coupon.error'),
                'message' => $this->trans($e->getMessage()),
            ];
        }

        return $this->jsonResponse($result);
    }
}
