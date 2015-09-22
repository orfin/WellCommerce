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
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;

/**
 * Class CartTotalsCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotalsCollector implements CartTotalsCollectorInterface
{
    /**
     * @var CurrencyConverterInterface
     */
    protected $converter;

    /**
     * Constructor
     *
     * @param CurrencyConverterInterface $converter
     */
    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
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
    public function collectTotalNetAmount(CartInterface $cart)
    {
        $price = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$price) {
            $product      = $cartProduct->getProduct();
            $baseCurrency = $product->getSellPrice()->getCurrency();
            $priceNet     = $product->getSellPrice()->getFinalNetAmount();
            $priceNet     = $this->converter->convert($priceNet, $baseCurrency);

            $price += $cartProduct->getQuantity() * $priceNet;
        });

        return $price;
    }
    
    /**
     * {@inheritdoc}
     */
    public function collectTotalGrossAmount(CartInterface $cart)
    {
        $price = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$price) {
            $product      = $cartProduct->getProduct();
            $baseCurrency = $product->getSellPrice()->getCurrency();
            $priceGross   = $product->getSellPrice()->getFinalGrossAmount();
            $priceGross   = $this->converter->convert($priceGross, $baseCurrency);

            $price += $cartProduct->getQuantity() * $priceGross;
        });

        return $price;
    }

    /**
     * {@inheritdoc}
     */
    public function collectTotalTaxAmount(CartInterface $cart)
    {
        $amount = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$amount) {
            $product      = $cartProduct->getProduct();
            $baseCurrency = $product->getSellPrice()->getCurrency();
            $taxAmount    = $product->getSellPrice()->getFinalTaxAmount();
            $taxAmount    = $this->converter->convert($taxAmount, $baseCurrency);

            $amount += $cartProduct->getQuantity() * $taxAmount;
        });

        return $amount;
    }
}
