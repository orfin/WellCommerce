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

namespace WellCommerce\Bundle\CouponBundle\Visitor;

use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Provider\OrderModifierProviderInterface;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorInterface;

/**
 * Class CouponOrderVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CouponOrderVisitor implements OrderVisitorInterface
{
    /**
     * @var OrderModifierProviderInterface
     */
    private $orderModifierProvider;

    /**
     * @var CurrencyHelperInterface
     */
    private $currencyHelper;

    /**
     * CouponOrderVisitor constructor.
     *
     * @param OrderModifierProviderInterface $orderModifierProvider
     * @param CurrencyHelperInterface        $currencyHelper
     */
    public function __construct(OrderModifierProviderInterface $orderModifierProvider, CurrencyHelperInterface $currencyHelper)
    {
        $this->orderModifierProvider = $orderModifierProvider;
        $this->currencyHelper        = $currencyHelper;
    }
    
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        if ($order->hasCoupon()) {
            $coupon        = $order->getCoupon();
            $modifierValue = $this->calculateCouponModifier($coupon, $order);
            $modifier      = $this->orderModifierProvider->getOrderModifier($order, 'coupon_discount');

            $modifier->setCurrency($order->getCurrency());
            $modifier->setGrossAmount($order->getProductTotal()->getGrossPrice() * $modifierValue);
            $modifier->setNetAmount($order->getProductTotal()->getNetPrice() * $modifierValue);
            $modifier->setTaxAmount($order->getProductTotal()->getTaxAmount() * $modifierValue);

        } else {
            $order->removeModifier('coupon_discount');
        }
    }
    
    private function calculateCouponModifier(CouponInterface $coupon, OrderInterface $order) : float
    {
        $modifierType    = $coupon->getModifierType();
        $modifierValue   = $coupon->getModifierValue();
        $baseCurrency    = $coupon->getCurrency();
        $targetCurrency  = $order->getCurrency();
        $totalGrossPrice = $order->getProductTotal()->getGrossPrice();

        if ('%' === $modifierType) {
            return $modifierValue / 100;
        }

        if ('-' === $modifierType) {
            $modifierValue = $this->currencyHelper->convert($modifierValue, $baseCurrency, $targetCurrency);

            return ($modifierValue >= $totalGrossPrice) ? 1 : $modifierValue / $totalGrossPrice;
        }

        return 1;
    }
}
