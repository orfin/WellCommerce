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

namespace WellCommerce\Bundle\OrderBundle\Collector;

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotal;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotalDetailInterface;

/**
 * Class OrderTotalCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderTotalCollector extends AbstractDataCollector
{
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        $totals         = $order->getTotals();
        $targetCurrency = $order->getCurrency();
        $orderTotal     = new OrderTotal();
        
        $grossTotal = 0;
        $netTotal   = 0;
        $taxTotal   = 0;
        
        $totals->map(function (OrderTotalDetailInterface $orderTotalDetail) use (&$grossTotal, &$netTotal, &$taxTotal, $targetCurrency) {
            $total        = $orderTotalDetail->getOrderTotal();
            $baseCurrency = $total->getCurrency();
            $grossAmount  = $this->currencyHelper->convert($total->getGrossAmount(), $baseCurrency, $targetCurrency);
            $netAmount    = $this->currencyHelper->convert($total->getNetAmount(), $baseCurrency, $targetCurrency);
            $taxAmount    = $this->currencyHelper->convert($total->getTaxAmount(), $baseCurrency, $targetCurrency);
            
            if ($orderTotalDetail->isSubtraction()) {
                $grossTotal -= $grossAmount;
                $netTotal -= $netAmount;
                $taxTotal -= $taxAmount;
            } else {
                $grossTotal += $grossAmount;
                $netTotal += $netAmount;
                $taxTotal += $taxAmount;
            }
        });
        
        $orderTotal->setCurrency($targetCurrency);
        $orderTotal->setGrossAmount($grossTotal);
        $orderTotal->setNetAmount($netTotal);
        $orderTotal->setTaxAmount($taxTotal);
        
        $order->setOrderTotal($orderTotal);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'total';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'order.label.total_description';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 500;
    }
}
