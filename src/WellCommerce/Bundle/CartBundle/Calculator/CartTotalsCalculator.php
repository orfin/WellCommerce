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

namespace WellCommerce\Bundle\CartBundle\Calculator;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CartBundle\Factory\CartTotalsFactoryInterface;
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;

/**
 * Class CartTotalsCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotalsCalculator implements CartTotalsCalculatorInterface
{
    /**
     * @var CartInterface
     */
    protected $cart;

    /**
     * @var CurrencyConverterInterface
     */
    protected $currencyConverter;

    /**
     * Constructor
     *
     * @param CurrencyConverterInterface $currencyConverter
     */
    public function __construct(CurrencyConverterInterface $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(CartInterface $cart)
    {
        $products       = $cart->getProducts();
        $quantityTotal  = $this->calculateCartTotalQuantity($products);
        $weightTotal    = $this->calculateCartTotalWeight($products);
        $netTotal       = $this->calculateCartTotalNetPrice($products);
        $grossTotal     = $this->calculateCartTotalGrossPrice($products);
        $taxAmountTotal = $grossTotal - $netTotal;

        $cartTotals = $cart->getTotals();
        $cartTotals->setQuantity($quantityTotal);
        $cartTotals->setWeight($weightTotal);
        $cartTotals->setNetPrice($netTotal);
        $cartTotals->setGrossPrice($grossTotal);
        $cartTotals->setTaxAmount($taxAmountTotal);

    }

    /**
     * Calculates total quantity of all products in cart
     *
     * @param Collection $collection
     *
     * @return int
     */
    private function calculateCartTotalQuantity(Collection $collection)
    {
        $quantity = 0;
        $collection->map(function (CartProductInterface $cartProduct) use (&$quantity) {
            $quantity += $cartProduct->getQuantity();
        });

        return $quantity;
    }

    /**
     * Calculates total weight of all products in cart
     *
     * @param Collection $collection
     *
     * @return float
     */
    private function calculateCartTotalWeight(Collection $collection)
    {
        $weight = 0;
        $collection->map(function (CartProductInterface $cartProduct) use (&$weight) {
            $product = $cartProduct->getProduct();

            $weight += $product->getWeight() * $cartProduct->getQuantity();
        });

        return $weight;
    }

    /**
     * Calculates total net price of all products in cart
     *
     * @param Collection $collection
     *
     * @return float
     */
    private function calculateCartTotalNetPrice(Collection $collection)
    {
        $totalNetPrice = 0;
        $collection->map(function (CartProductInterface $cartProduct) use (&$totalNetPrice) {
            $product       = $cartProduct->getProduct();
            $baseCurrency  = $product->getSellPrice()->getCurrency();
            $priceNet      = $product->getSellPrice()->getAmount();
            $quantityPrice = $cartProduct->getQuantity() * $priceNet;

            $totalNetPrice += $this->currencyConverter->convert($quantityPrice, $baseCurrency);
        });

        return $totalNetPrice;
    }

    /**
     * Calculates total net price of all products in cart
     *
     * @param Collection $collection
     *
     * @return float
     */
    private function calculateCartTotalGrossPrice(Collection $collection)
    {
        $totalGrossPrice = 0;
        $collection->map(function (CartProductInterface $cartProduct) use (&$totalGrossPrice) {
            $product       = $cartProduct->getProduct();
            $baseCurrency  = $product->getSellPrice()->getCurrency();
            $tax           = $product->getSellPriceTax();
            $priceNet      = $product->getSellPrice()->getAmount();
            $priceGross    = $tax->calculateGrossPrice($priceNet);
            $priceGross    = $this->currencyConverter->convert($priceGross, $baseCurrency);
            $quantityPrice = $cartProduct->getQuantity() * $priceGross;

            $totalGrossPrice += $this->currencyConverter->convert($quantityPrice, $baseCurrency);
        });

        return $totalGrossPrice;
    }
}
