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
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotal;

/**
 * Class OrderProductTotalCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductTotalCollector extends AbstractDataCollector
{
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        $orderProductTotal = $this->prepareOrderProductTotal($order);
        $order->setProductTotal($orderProductTotal);
        
        $orderTotalDetail = $this->initResource();
        $orderTotalDetail->setOrderTotal($orderProductTotal);
        $orderTotalDetail->setOrder($order);
        
        $order->addTotal($orderTotalDetail);
    }
    
    /**
     * Prepares order product totals
     *
     * @param OrderInterface $order
     *
     * @return OrderTotal
     */
    protected function prepareOrderProductTotal(OrderInterface $order)
    {
        $grossAmountTotal = $this->calculateTotalGrossAmount($order);
        $netAmountTotal   = $this->calculateTotalNetAmount($order);
        $taxAmountTotal   = $this->calculateTotalTaxAmount($order);
        
        $productTotal = new OrderTotal();
        $productTotal->setGrossAmount($grossAmountTotal);
        $productTotal->setNetAmount($netAmountTotal);
        $productTotal->setTaxAmount($taxAmountTotal);
        $productTotal->setCurrency($order->getCurrency());
        
        return $productTotal;
    }
    
    /**
     * {@inheritdoc}
     */
    public function calculateTotalNetAmount(OrderInterface $order)
    {
        $price          = 0;
        $targetCurrency = $order->getCurrency();
        
        $order->getProducts()->map(function (OrderProductInterface $orderProduct) use (&$price, $targetCurrency) {
            $sellPrice    = $orderProduct->getSellPrice();
            $baseCurrency = $sellPrice->getCurrency();
            $priceNet     = $sellPrice->getNetAmount();
            
            $price += $this->currencyHelper->convert($priceNet, $baseCurrency, $targetCurrency, $orderProduct->getQuantity());
        });
        
        return $price;
    }
    
    /**
     * {@inheritdoc}
     */
    public function calculateTotalGrossAmount(OrderInterface $order)
    {
        $price          = 0;
        $targetCurrency = $order->getCurrency();
        
        $order->getProducts()->map(function (OrderProductInterface $orderProduct) use (&$price, $targetCurrency) {
            $sellPrice    = $orderProduct->getSellPrice();
            $baseCurrency = $sellPrice->getCurrency();
            $priceGross   = $sellPrice->getGrossAmount();
            
            $price += $this->currencyHelper->convert($priceGross, $baseCurrency, $targetCurrency, $orderProduct->getQuantity());
        });
        
        return $price;
    }
    
    /**
     * {@inheritdoc}
     */
    public function calculateTotalTaxAmount(OrderInterface $order)
    {
        $amount         = 0;
        $targetCurrency = $order->getCurrency();
        
        $order->getProducts()->map(function (OrderProductInterface $orderProduct) use (&$amount, $targetCurrency) {
            $sellPrice    = $orderProduct->getSellPrice();
            $baseCurrency = $sellPrice->getCurrency();
            $taxAmount    = $sellPrice->getTaxAmount();
            
            $amount += $this->currencyHelper->convert($taxAmount, $baseCurrency, $targetCurrency, $orderProduct->getQuantity());
        });
        
        return $amount;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'product_total';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'order.label.product_total_description';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }
}
