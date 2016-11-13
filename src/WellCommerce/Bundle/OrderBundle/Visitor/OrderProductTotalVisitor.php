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

namespace WellCommerce\Bundle\OrderBundle\Visitor;

use WellCommerce\Bundle\OrderBundle\Calculator\OrderProductTotalCalculatorInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Class OrderProductTotalVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderProductTotalVisitor implements OrderVisitorInterface
{
    /**
     * @var OrderProductTotalCalculatorInterface
     */
    private $calculator;
    
    /**
     * OrderProductTotalVisitor constructor.
     *
     * @param OrderProductTotalCalculatorInterface $calculator
     */
    public function __construct (OrderProductTotalCalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
    }
    
    public function visitOrder (OrderInterface $order)
    {
        $summary = $order->getProductTotal();
        $summary->setQuantity($this->calculator->getTotalQuantity($order));
        $summary->setWeight($this->calculator->getTotalWeight($order));
        $summary->setNetPrice($this->calculator->getTotalNetAmount($order));
        $summary->setGrossPrice($this->calculator->getTotalGrossAmount($order));
        $summary->setTaxAmount($this->calculator->getTotalTaxAmount($order));
    }
}
