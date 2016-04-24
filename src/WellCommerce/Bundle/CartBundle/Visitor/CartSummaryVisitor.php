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

namespace WellCommerce\Bundle\CartBundle\Visitor;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartModifierInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartSummaryInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface;

/**
 * Class CartSummaryVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartSummaryVisitor implements CartVisitorInterface
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
    
    public function visitCart(CartInterface $cart)
    {
        $productTotal   = $cart->getProductTotal();
        $modifiers      = $cart->getModifiers();
        $targetCurrency = $cart->getCurrency();

        /** @var CartSummaryInterface $summary */
        $summary = $this->factory->create();
        $summary->setGrossAmount($productTotal->getGrossPrice());
        $summary->setNetAmount($productTotal->getNetPrice());
        $summary->setTaxAmount($productTotal->getTaxAmount());
        
        $modifiers->map(function (CartModifierInterface $modifier) use ($summary, $targetCurrency) {
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

        $cart->setSummary($summary);
    }
}
