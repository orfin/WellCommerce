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
 * Class TaxAmountCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxAmountCalculator implements CartCalculatorInterface
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
        $amount = $this->calculate($cart);
        $cart->getTotals()->setTaxAmount($amount);
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(CartInterface $cart)
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

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'tax_amount';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 30;
    }
}
