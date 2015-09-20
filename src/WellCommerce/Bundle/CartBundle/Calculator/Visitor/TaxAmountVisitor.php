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

namespace WellCommerce\Bundle\CartBundle\Calculator\Visitor;

use WellCommerce\Bundle\CartBundle\Calculator\CartTotalsVisitorInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartInterface;

/**
 * Class TaxAmountVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxAmountVisitor implements CartTotalsVisitorInterface
{
    /**
     * {@inheritdoc}
     */
    public function visitCart(CartInterface $cart)
    {
        $netAmount   = $cart->getTotals()->getNetPrice();
        $grossAmount = $cart->getTotals()->getGrossPrice();

        $cart->getTotals()->setTaxAmount($grossAmount - $netAmount);
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
