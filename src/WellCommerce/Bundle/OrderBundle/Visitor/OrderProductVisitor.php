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

use WellCommerce\Bundle\AppBundle\Factory\PriceFactory;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\ProductBundle\Helper\VariantHelperInterface;

/**
 * Class OrderProductVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderProductVisitor implements OrderVisitorInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    private $currencyHelper;
    
    /**
     * @var VariantHelperInterface
     */
    private $variantHelper;
    
    /**
     * @var PriceFactory
     */
    private $priceFactory;
    
    /**
     * OrderProductVisitor constructor.
     *
     * @param CurrencyHelperInterface $currencyHelper
     * @param VariantHelperInterface  $variantHelper
     * @param PriceFactory            $priceFactory
     */
    public function __construct(CurrencyHelperInterface $currencyHelper, VariantHelperInterface $variantHelper, PriceFactory $priceFactory)
    {
        $this->currencyHelper = $currencyHelper;
        $this->variantHelper  = $variantHelper;
        $this->priceFactory   = $priceFactory;
    }
    
    public function visitOrder(OrderInterface $order)
    {
        $order->getProducts()->map(function (OrderProductInterface $orderProduct) use ($order) {
            if (false === $orderProduct->isLocked()) {
                if ($this->checkOrderStock($order, $orderProduct)) {
                    $this->refreshOrderProductSellPrice($orderProduct);
                    $this->refreshOrderProductBuyPrice($orderProduct);
                    $this->refreshOrderProductVariantOptions($orderProduct);
                }
            }
        });
    }
    
    private function checkOrderStock(OrderInterface $order, OrderProductInterface $orderProduct) : bool
    {
        $trackStock      = $orderProduct->getProduct()->getTrackStock();
        $orderedQuantity = $orderProduct->getQuantity();
        $stock           = $orderProduct->getCurrentStock();
        
        if ($trackStock && $orderedQuantity > $stock) {
            if ($stock > 0) {
                $orderProduct->setQuantity($stock);
            } else {
                $order->removeProduct($orderProduct);
                
                return false;
            }
        }
        
        return true;
    }
    
    private function refreshOrderProductSellPrice(OrderProductInterface $orderProduct)
    {
        $baseSellPrice  = $orderProduct->getCurrentSellPrice();
        $baseCurrency   = $baseSellPrice->getCurrency();
        $targetCurrency = $orderProduct->getOrder()->getCurrency();
        $grossAmount    = $this->currencyHelper->convert($baseSellPrice->getFinalGrossAmount(), $baseCurrency, $targetCurrency);
        $netAmount      = $this->currencyHelper->convert($baseSellPrice->getFinalNetAmount(), $baseCurrency, $targetCurrency);
        $taxAmount      = $this->currencyHelper->convert($baseSellPrice->getFinalTaxAmount(), $baseCurrency, $targetCurrency);
        
        $sellPrice = $this->priceFactory->create();
        $sellPrice->setCurrency($targetCurrency);
        $sellPrice->setGrossAmount($grossAmount);
        $sellPrice->setNetAmount($netAmount);
        $sellPrice->setTaxAmount($taxAmount);
        $sellPrice->setTaxRate($baseSellPrice->getTaxRate());
        
        $orderProduct->setSellPrice($sellPrice);
    }
    
    private function refreshOrderProductBuyPrice(OrderProductInterface $orderProduct)
    {
        $baseBuyPrice   = $orderProduct->getProduct()->getBuyPrice();
        $baseCurrency   = $baseBuyPrice->getCurrency();
        $targetCurrency = $orderProduct->getOrder()->getCurrency();
        $grossAmount    = $this->currencyHelper->convert($baseBuyPrice->getGrossAmount(), $baseCurrency, $targetCurrency);
        $netAmount      = $this->currencyHelper->convert($baseBuyPrice->getNetAmount(), $baseCurrency, $targetCurrency);
        $taxAmount      = $this->currencyHelper->convert($baseBuyPrice->getTaxAmount(), $baseCurrency, $targetCurrency);
        
        $buyPrice = $this->priceFactory->create();
        $buyPrice->setCurrency($targetCurrency);
        $buyPrice->setGrossAmount($grossAmount);
        $buyPrice->setNetAmount($netAmount);
        $buyPrice->setTaxAmount($taxAmount);
        $buyPrice->setTaxRate($baseBuyPrice->getTaxRate());
        
        $orderProduct->setBuyPrice($buyPrice);
    }
    
    private function refreshOrderProductVariantOptions(OrderProductInterface $orderProduct)
    {
        if ($orderProduct->hasVariant()) {
            $options = $this->variantHelper->getVariantOptions($orderProduct->getVariant());
            $orderProduct->setOptions($options);
        }
    }
}
