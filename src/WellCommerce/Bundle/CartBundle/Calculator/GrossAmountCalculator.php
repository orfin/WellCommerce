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

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;

/**
 * Class GrossAmountCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class GrossAmountCalculator implements CartCalculatorInterface
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
    public function visitCart(CartInterface $cart)
    {
        $price = $this->calculate($cart);
        $cart->getTotals()->setGrossPrice($price);
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(CartInterface $cart)
    {
        $price = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$price) {
            $product       = $cartProduct->getProduct();
            $baseCurrency  = $product->getSellPrice()->getCurrency();
            $tax           = $product->getSellPriceTax();
            $priceNet      = $product->getSellPrice()->getAmount();
            $priceGross    = $tax->calculateGrossPrice($priceNet);
            $priceGross    = $this->converter->convert($priceGross, $baseCurrency);
            $quantityPrice = $cartProduct->getQuantity() * $priceGross;

            $price += $this->converter->convert($quantityPrice, $baseCurrency);
        });

        return $price;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'gross_amount';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 20;
    }
}
