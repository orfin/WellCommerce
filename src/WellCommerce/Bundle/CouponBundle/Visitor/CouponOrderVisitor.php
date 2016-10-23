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
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
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
            $coupon          = $order->getCoupon();
            $totalGrossPrice = $this->getOrderGrossPrice($coupon, $order);
            $totalNetPrice   = $this->getOrderNetPrice($coupon, $order);
            $totalTaxAmount  = $this->getOrderTaxAmount($coupon, $order);
            $modifierValue   = $this->calculateCouponModifier($coupon, $order, $totalGrossPrice);
            $modifier        = $this->orderModifierProvider->getOrderModifier($order, 'coupon_discount');
            
            $modifier->setCurrency($order->getCurrency());
            $modifier->setGrossAmount($totalGrossPrice * $modifierValue);
            $modifier->setNetAmount($totalNetPrice * $modifierValue);
            $modifier->setTaxAmount($totalTaxAmount * $modifierValue);
            
        } else {
            $order->removeModifier('coupon_discount');
        }
    }
    
    private function calculateCouponModifier(CouponInterface $coupon, OrderInterface $order, float $totalGrossPrice) : float
    {
        $modifierType   = $coupon->getModifierType();
        $modifierValue  = $coupon->getModifierValue();
        $baseCurrency   = $coupon->getCurrency();
        $targetCurrency = $order->getCurrency();
        
        if ('%' === $modifierType) {
            return $modifierValue / 100;
        }
        
        if ('-' === $modifierType) {
            $modifierValue = $this->currencyHelper->convert($modifierValue, $baseCurrency, $targetCurrency);
            
            return ($modifierValue >= $totalGrossPrice) ? 1 : $modifierValue / $totalGrossPrice;
        }
        
        return 1;
    }
    
    private function getOrderGrossPrice(CouponInterface $coupon, OrderInterface $order) : float
    {
        if (true === $coupon->isExcludePromotions()) {
            $targetCurrency = $order->getCurrency();
            $gross          = 0;
            $order->getProducts()->map(function (OrderProductInterface $orderProduct) use (&$gross, $targetCurrency) {
                if (false === $orderProduct->getProduct()->getSellPrice()->isDiscountValid()) {
                    $sellPrice    = $orderProduct->getSellPrice();
                    $baseCurrency = $sellPrice->getCurrency();
                    $priceGross   = $sellPrice->getGrossAmount();
                    
                    $gross += $this->currencyHelper->convert($priceGross, $baseCurrency, $targetCurrency, $orderProduct->getQuantity());
                }
            });
            
            return $gross;
        }
        
        return $order->getProductTotal()->getGrossPrice();
    }
    
    private function getOrderNetPrice(CouponInterface $coupon, OrderInterface $order) : float
    {
        if (true === $coupon->isExcludePromotions()) {
            $targetCurrency = $order->getCurrency();
            $gross          = 0;
            $order->getProducts()->map(function (OrderProductInterface $orderProduct) use (&$gross, $targetCurrency) {
                if (false === $orderProduct->getProduct()->getSellPrice()->isDiscountValid()) {
                    $sellPrice    = $orderProduct->getSellPrice();
                    $baseCurrency = $sellPrice->getCurrency();
                    $priceNet     = $sellPrice->getNetAmount();
                    
                    $gross += $this->currencyHelper->convert($priceNet, $baseCurrency, $targetCurrency, $orderProduct->getQuantity());
                }
            });
            
            return $gross;
        }
        
        return $order->getProductTotal()->getNetPrice();
    }
    
    private function getOrderTaxAmount(CouponInterface $coupon, OrderInterface $order) : float
    {
        if (true === $coupon->isExcludePromotions()) {
            $targetCurrency = $order->getCurrency();
            $gross          = 0;
            $order->getProducts()->map(function (OrderProductInterface $orderProduct) use (&$gross, $targetCurrency) {
                if (false === $orderProduct->getProduct()->getSellPrice()->isDiscountValid()) {
                    $sellPrice    = $orderProduct->getSellPrice();
                    $baseCurrency = $sellPrice->getCurrency();
                    $taxAmount    = $sellPrice->getTaxAmount();
                    
                    $gross += $this->currencyHelper->convert($taxAmount, $baseCurrency, $targetCurrency, $orderProduct->getQuantity());
                }
            });
            
            return $gross;
        }
        
        return $order->getProductTotal()->getTaxAmount();
    }
}
