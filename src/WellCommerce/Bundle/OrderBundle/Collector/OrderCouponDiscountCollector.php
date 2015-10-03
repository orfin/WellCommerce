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

namespace WellCommerce\Bundle\OrderBundle\Collector;

use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotal;

/**
 * Class OrderCouponDiscountCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderCouponDiscountCollector extends AbstractDataCollector
{
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        if (null !== $order->getCoupon()) {
            $productTotal = $order->getProductTotal();
            $coupon       = $order->getCoupon();
            $modifier     = $this->calculateModifierValue($coupon, $productTotal->getGrossAmount(), $order->getCurrency());

            if ($modifier > 0) {
                $discountTotal = new OrderTotal();
                $discountTotal->setCurrency($order->getCurrency());
                $discountTotal->setGrossAmount($productTotal->getGrossAmount() * $modifier);
                $discountTotal->setNetAmount($productTotal->getNetAmount() * $modifier);
                $discountTotal->setTaxAmount($productTotal->getTaxAmount() * $modifier);

                $clientDiscountDetail = $this->initResource();
                $clientDiscountDetail->setOrderTotal($discountTotal);
                $clientDiscountDetail->setModifierType($coupon->getModifierType());
                $clientDiscountDetail->setModifierValue($modifier);
                $clientDiscountDetail->setOrder($order);
                $clientDiscountDetail->setSubtraction(true);

                $order->addTotal($clientDiscountDetail);
            }
        }
    }

    /**
     * Calculates the modifier's value according to current currency and coupon's modifier
     *
     * @param CouponInterface $coupon
     * @param float|int       $amount
     * @param string          $targetCurrency
     *
     * @return float|int
     */
    protected function calculateModifierValue(CouponInterface $coupon, $amount, $targetCurrency)
    {
        $modifierType  = $coupon->getModifierType();
        $modifierValue = $coupon->getModifierValue();
        $baseCurrency  = $coupon->getCurrency();

        switch ($modifierType) {
            case '-':
                $modifierValue = $this->currencyHelper->convert($modifierValue, $baseCurrency, $targetCurrency);
                $modifier      = $modifierValue / $amount;
                break;
            case '%':
                $modifier = $modifierValue / 100;
                break;
            default:
                $modifier = 0;
        }

        return $modifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'coupon_discount';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'order.label.coupon_discount_description';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 400;
    }
}
