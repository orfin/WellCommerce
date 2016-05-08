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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CouponBundle\Checker\CouponCheckerInterface;
use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;
use WellCommerce\Bundle\CouponBundle\Exception\CouponException;

/**
 * Class CouponController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponController extends AbstractFrontController
{
    public function addAction(CouponInterface $coupon = null) : JsonResponse
    {
        try {
            if (!$this->getCouponChecker()->isValid($coupon)) {
                throw new CouponException($this->getCouponChecker()->getError());
            }

            $this->getOrderStorage()->getCurrentOrder()->setCoupon($coupon);

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

    public function deleteAction(Request $request) : JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('cart.front.index');
        }

        try {
            $this->getOrderStorage()->getCurrentOrder()->removeCoupon();

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

    protected function getCouponChecker() : CouponCheckerInterface
    {
        return $this->get('coupon.checker');
    }
}
