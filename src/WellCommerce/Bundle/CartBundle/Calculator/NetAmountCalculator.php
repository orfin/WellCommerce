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
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorInterface;
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;

/**
 * Class NetAmountCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NetAmountCalculator implements CartVisitorInterface
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
        $price = 0;
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use (&$price) {
            $product       = $cartProduct->getProduct();
            $baseCurrency  = $product->getSellPrice()->getCurrency();
            $priceNet      = $product->getSellPrice()->getAmount();
            $quantityPrice = $cartProduct->getQuantity() * $priceNet;

            $price += $this->converter->convert($quantityPrice, $baseCurrency);
        });

        $cart->getTotals()->setNetPrice($price);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'net_amount';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 10;
    }
}
