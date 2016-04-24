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

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartModifierManagerInterface;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorInterface;
use WellCommerce\Bundle\CouponBundle\Entity\CouponInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;

/**
 * Class CouponCartVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CouponCartVisitor implements CartVisitorInterface
{
    /**
     * @var CartModifierManagerInterface
     */
    private $cartModifierManager;

    /**
     * CouponCartVisitor constructor.
     *
     * @param CartModifierManagerInterface $cartModifierManager
     */
    public function __construct(CartModifierManagerInterface $cartModifierManager)
    {
        $this->cartModifierManager = $cartModifierManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function visitCart(CartInterface $cart)
    {
        if ($cart->hasCoupon()) {
            $coupon        = $cart->getCoupon();
            $modifierValue = $this->calculateCouponModifier($coupon, $cart);
            $modifier      = $this->cartModifierManager->getCartModifier($cart, 'coupon_discount');

            $modifier->setCurrency($cart->getCurrency());
            $modifier->setGrossAmount($cart->getProductTotal()->getGrossPrice() * $modifierValue);
            $modifier->setNetAmount($cart->getProductTotal()->getNetPrice() * $modifierValue);
            $modifier->setTaxAmount($cart->getProductTotal()->getTaxAmount() * $modifierValue);

        } else {
            $cart->removeModifier('coupon_discount');
        }
    }
    
    private function calculateCouponModifier(CouponInterface $coupon, CartInterface $cart) : float
    {
        $modifierType    = $coupon->getModifierType();
        $modifierValue   = $coupon->getModifierValue();
        $baseCurrency    = $coupon->getCurrency();
        $targetCurrency  = $cart->getCurrency();
        $totalGrossPrice = $cart->getProductTotal()->getGrossPrice();

        if ('%' === $modifierType) {
            return $modifierValue / 100;
        }

        if ('-' === $modifierType) {
            $modifierValue = $this->getCurrencyHelper()->convert($modifierValue, $baseCurrency, $targetCurrency);

            return ($modifierValue >= $totalGrossPrice) ? 1 : $modifierValue / $totalGrossPrice;
        }

        return 1;
    }

    private function getCurrencyHelper() : CurrencyHelperInterface
    {
        return $this->cartModifierManager->getCurrencyHelper();
    }
}
