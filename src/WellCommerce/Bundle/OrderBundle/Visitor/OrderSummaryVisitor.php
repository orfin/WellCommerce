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

use WellCommerce\Bundle\CoreBundle\Factory\EntityFactoryInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderModifierInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderSummaryInterface;

/**
 * Class OrderSummaryVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderSummaryVisitor implements OrderVisitorInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    private $helper;
    
    /**
     * @var EntityFactoryInterface
     */
    private $factory;
    
    /**
     * CartSummaryVisitor constructor.
     *
     * @param CurrencyHelperInterface $helper
     * @param EntityFactoryInterface  $factory
     */
    public function __construct(CurrencyHelperInterface $helper, EntityFactoryInterface $factory)
    {
        $this->helper  = $helper;
        $this->factory = $factory;
    }
    
    public function visitOrder(OrderInterface $order)
    {
        $productTotal   = $order->getProductTotal();
        $modifiers      = $order->getModifiers();
        $targetCurrency = $order->getCurrency();
        
        /** @var OrderSummaryInterface $summary */
        $summary = $this->factory->create();
        $summary->setGrossAmount($productTotal->getGrossPrice());
        $summary->setNetAmount($productTotal->getNetPrice());
        $summary->setTaxAmount($productTotal->getTaxAmount());
        
        $modifiers->map(function (OrderModifierInterface $modifier) use ($summary, $targetCurrency) {
            $baseCurrency = $modifier->getCurrency();
            $grossAmount  = $this->helper->convert($modifier->getGrossAmount(), $baseCurrency, $targetCurrency);
            $netAmount    = $this->helper->convert($modifier->getNetAmount(), $baseCurrency, $targetCurrency);
            $taxAmount    = $this->helper->convert($modifier->getTaxAmount(), $baseCurrency, $targetCurrency);
            
            if ($modifier->isSubtraction()) {
                $summary->setGrossAmount($summary->getGrossAmount() - $grossAmount);
                $summary->setNetAmount($summary->getNetAmount() - $netAmount);
                $summary->setTaxAmount($summary->getTaxAmount() - $taxAmount);
            } else {
                $summary->setGrossAmount($summary->getGrossAmount() + $grossAmount);
                $summary->setNetAmount($summary->getNetAmount() + $netAmount);
                $summary->setTaxAmount($summary->getTaxAmount() + $taxAmount);
            }
        });
        
        $order->setSummary($summary);
    }
}
