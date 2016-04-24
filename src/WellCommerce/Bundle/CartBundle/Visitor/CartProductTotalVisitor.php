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

namespace WellCommerce\Bundle\CartBundle\Visitor;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;

/**
 * Class CartProductTotalVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartProductTotalVisitor implements CartVisitorInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    private $helper;

    /**
     * CartProductTotalVisitor constructor.
     *
     * @param CurrencyHelperInterface $helper
     */
    public function __construct(CurrencyHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    public function visitCart(CartInterface $cart)
    {
        $summary = $cart->getProductTotal();
        $summary->setQuantity($this->calculateQuantity($cart));
        $summary->setWeight($this->calculateWeight($cart));
        $summary->setNetPrice($this->calculateNetPrice($cart));
        $summary->setGrossPrice($this->calculateGrossPrice($cart));
        $summary->setTaxAmount($this->calculateTaxAmount($cart));
    }
    
    private function calculateQuantity(CartInterface $cart) : int
    {
        $quantity = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$quantity) {
            $quantity += $cartProduct->getQuantity();
        });

        return $quantity;
    }

    private function calculateWeight(CartInterface $cart) : float
    {
        $weight = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$weight) {
            $weight += $cartProduct->getWeight() * $cartProduct->getQuantity();
        });

        return $weight;
    }

    private function calculateNetPrice(CartInterface $cart) : float
    {
        $targetCurrency = $cart->getCurrency();
        $net            = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$net, $targetCurrency) {
            $sellPrice    = $cartProduct->getSellPrice();
            $baseCurrency = $sellPrice->getCurrency();
            $priceNet     = $sellPrice->getFinalNetAmount();

            $net += $this->helper->convert($priceNet, $baseCurrency, $targetCurrency, $cartProduct->getQuantity());
        });

        return $net;
    }

    private function calculateGrossPrice(CartInterface $cart) : float
    {
        $targetCurrency = $cart->getCurrency();
        $gross          = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$gross, $targetCurrency) {
            $sellPrice    = $cartProduct->getSellPrice();
            $baseCurrency = $sellPrice->getCurrency();
            $priceGross   = $sellPrice->getFinalGrossAmount();

            $gross += $this->helper->convert($priceGross, $baseCurrency, $targetCurrency, $cartProduct->getQuantity());
        });

        return $gross;
    }

    private function calculateTaxAmount(CartInterface $cart) : float
    {
        $targetCurrency = $cart->getCurrency();
        $tax            = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$tax, $targetCurrency) {
            $sellPrice    = $cartProduct->getSellPrice();
            $baseCurrency = $sellPrice->getCurrency();
            $taxAmount    = $sellPrice->getFinalTaxAmount();

            $tax += $this->helper->convert($taxAmount, $baseCurrency, $targetCurrency, $cartProduct->getQuantity());
        });

        return $tax;
    }
}
