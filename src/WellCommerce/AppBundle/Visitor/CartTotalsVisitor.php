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

namespace WellCommerce\AppBundle\Visitor;

use WellCommerce\AppBundle\Collector\CartTotalsCollectorInterface;
use WellCommerce\AppBundle\Entity\CartInterface;

/**
 * Class CartTotalsVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotalsVisitor implements CartVisitorInterface
{
    /**
     * @var CartTotalsCollectorInterface
     */
    protected $cartTotalsCollector;

    /**
     * @param CartTotalsCollectorInterface $cartTotalsCollector
     */
    public function __construct(CartTotalsCollectorInterface $cartTotalsCollector)
    {
        $this->cartTotalsCollector = $cartTotalsCollector;
    }

    /**
     * {@inheritdoc}
     */
    public function visitCart(CartInterface $cart)
    {
        $totals           = $cart->getTotals();
        $totalGrossAmount = $this->cartTotalsCollector->collectTotalGrossAmount($cart);
        $totalNetAmount   = $this->cartTotalsCollector->collectTotalNetAmount($cart);
        $totalTaxAmount   = $this->cartTotalsCollector->collectTotalTaxAmount($cart);
        $totalQuantity    = $this->cartTotalsCollector->collectTotalQuantity($cart);
        $totalQWeight     = $this->cartTotalsCollector->collectTotalWeight($cart);

        $totals->setQuantity($totalQuantity);
        $totals->setWeight($totalQWeight);
        $totals->setGrossPrice($totalGrossAmount);
        $totals->setNetPrice($totalNetAmount);
        $totals->setTaxAmount($totalTaxAmount);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'cart_totals';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }
}
