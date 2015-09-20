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

/**
 * Class TaxAmountCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxAmountCalculator implements CartCalculatorInterface
{
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
        $netAmount   = $cart->getTotals()->getNetPrice();
        $grossAmount = $cart->getTotals()->getGrossPrice();

        return $grossAmount - $netAmount;
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
