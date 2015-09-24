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

namespace WellCommerce\Bundle\CartBundle\Collector;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\IntlBundle\Helper\CurrencyHelperInterface;

/**
 * Class CartTotalsCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotalsCollector implements CartTotalsCollectorInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param CurrencyHelperInterface $helper
     */
    public function __construct(CurrencyHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function collectTotalQuantity(CartInterface $cart)
    {
        $quantity = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$quantity) {
            $quantity += $cartProduct->getQuantity();
        });

        return $quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function collectTotalWeight(CartInterface $cart)
    {
        $weight = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$weight) {
            $product = $cartProduct->getProduct();

            $weight += $product->getWeight() * $cartProduct->getQuantity();
        });

        return $weight;
    }

    /**
     * {@inheritdoc}
     */
    public function collectTotalNetAmount(CartInterface $cart, $targetCurrency = null)
    {
        $price = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$price, &$targetCurrency) {
            $product      = $cartProduct->getProduct();
            $baseCurrency = $product->getSellPrice()->getCurrency();
            $priceNet     = $product->getSellPrice()->getFinalNetAmount();

            $price += $this->helper->convert($priceNet, $baseCurrency, $targetCurrency, $cartProduct->getQuantity());
        });

        return $price;
    }
    
    /**
     * {@inheritdoc}
     */
    public function collectTotalGrossAmount(CartInterface $cart, $targetCurrency = null)
    {
        $price = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$price, &$targetCurrency) {
            $product      = $cartProduct->getProduct();
            $baseCurrency = $product->getSellPrice()->getCurrency();
            $priceGross   = $product->getSellPrice()->getFinalGrossAmount();

            $price += $this->helper->convert($priceGross, $baseCurrency, $targetCurrency, $cartProduct->getQuantity());
        });

        return $price;
    }

    /**
     * {@inheritdoc}
     */
    public function collectTotalTaxAmount(CartInterface $cart, $targetCurrency = null)
    {
        $amount = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$amount, &$targetCurrency) {
            $product      = $cartProduct->getProduct();
            $baseCurrency = $product->getSellPrice()->getCurrency();
            $taxAmount    = $product->getSellPrice()->getFinalTaxAmount();

            $amount += $this->helper->convert($taxAmount, $baseCurrency, $targetCurrency, $cartProduct->getQuantity());
        });

        return $amount;
    }
}
