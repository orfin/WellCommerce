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

namespace WellCommerce\Bundle\CartBundle\Helper;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Entity\CartProduct;
use WellCommerce\Bundle\CartBundle\Entity\CartTotals;
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;

/**
 * Class CartHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartHelper implements CartHelperInterface
{
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
    public function recalculateCartTotals(Cart $cart)
    {
        $products       = $cart->getProducts();
        $quantityTotal  = $this->calculateCartTotalQuantity($products);
        $weightTotal    = $this->calculateCartTotalWeight($products);
        $netTotal       = $this->calculateCartTotalNetPrice($products);
        $grossTotal     = $this->calculateCartTotalGrossPrice($products);
        $taxAmountTotal = $grossTotal - $netTotal;

        $cartTotals = new CartTotals($quantityTotal, $weightTotal, $netTotal, $grossTotal, $taxAmountTotal);
        $cart->setTotals($cartTotals);

        return true;
    }

    /**
     * Calculates total quantity of all products in cart
     *
     * @param CartProduct[] $collection
     *
     * @return float
     */
    private function calculateCartTotalQuantity($collection)
    {
        $quantity = 0;
        foreach ($collection as $item) {
            $quantity += $item->getQuantity();
        }

        return $quantity;
    }

    /**
     * Calculates total weight of all products in cart
     *
     * @param CartProduct[] $collection
     *
     * @return float
     */
    private function calculateCartTotalWeight($collection)
    {
        $weight = 0;
        foreach ($collection as $item) {
            $product = $item->getProduct();

            $weight += $product->getWeight() * $item->getQuantity();
        }

        return $weight;
    }

    /**
     * Calculates total net price of all products in cart
     *
     * @param CartProduct[] $collection
     *
     * @return float
     */
    private function calculateCartTotalNetPrice($collection)
    {
        $totalNetPrice = 0;
        foreach ($collection as $item) {
            $product       = $item->getProduct();
            $baseCurrency  = $product->getSellPrice()->getCurrency();
            $priceNet      = $product->getSellPrice()->getAmount();
            $quantityPrice = $item->getQuantity() * $priceNet;

            $totalNetPrice += $this->currencyConverter->convert($quantityPrice, $baseCurrency);
        }

        return $totalNetPrice;
    }

    /**
     * Calculates total net price of all products in cart
     *
     * @param CartProduct[] $collection
     *
     * @return float
     */
    private function calculateCartTotalGrossPrice($collection)
    {
        $totalGrossPrice = 0;
        foreach ($collection as $item) {
            $product       = $item->getProduct();
            $baseCurrency  = $product->getSellPrice()->getCurrency();
            $tax           = $product->getSellPriceTax();
            $priceNet      = $product->getSellPrice()->getAmount();
            $priceGross    = $tax->calculateGrossPrice($priceNet);
            $quantityPrice = $item->getQuantity() * $priceGross;

            $totalGrossPrice += $this->currencyConverter->convert($quantityPrice, $baseCurrency);
        }

        return $totalGrossPrice;
    }
}
