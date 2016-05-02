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

namespace WellCommerce\Bundle\OrderBundle\Manager;

use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\OrderBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;

/**
 * Class OrderProductManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductManager extends AbstractFrontManager
{
    public function transformCartProduct(CartProductInterface $cartProduct) : OrderProductInterface
    {
        /** @var OrderProductInterface $orderProduct */
        $orderProduct   = $this->initResource();
        $product        = $cartProduct->getProduct();
        $variant        = $cartProduct->getVariant();
        $sellPrice      = $cartProduct->getSellPrice();
        $baseCurrency   = $sellPrice->getCurrency();
        $targetCurrency = $order->getCurrency();
        
        $grossAmount = $this->getCurrencyHelper()->convert($sellPrice->getFinalGrossAmount(), $baseCurrency, $targetCurrency);
        $netAmount   = $this->getCurrencyHelper()->convert($sellPrice->getFinalNetAmount(), $baseCurrency, $targetCurrency);
        $taxAmount   = $this->getCurrencyHelper()->convert($sellPrice->getFinalTaxAmount(), $baseCurrency, $targetCurrency);
        
        $sellPrice = new Price();
        $sellPrice->setGrossAmount($grossAmount);
        $sellPrice->setNetAmount($netAmount);
        $sellPrice->setTaxAmount($taxAmount);
        $sellPrice->setTaxRate($sellPrice->getTaxRate());
        $sellPrice->setCurrency($targetCurrency);
        
        $orderProduct->setSellPrice($sellPrice);
        $orderProduct->setBuyPrice($product->getBuyPrice());
        $orderProduct->setQuantity($cartProduct->getQuantity());
        $orderProduct->setWeight($cartProduct->getWeight());
        $orderProduct->setVariant($variant);
        $orderProduct->setProduct($product);
        
        return $orderProduct;
    }
    
    protected function prepareOrderProducts(CartInterface $cart, OrderInterface $order)
    {
        $cart->getProducts()->map(function (CartProductInterface $cartProduct) use ($order) {
            $orderProduct = $this->prepareOrderProduct($cartProduct, $order);
            $orderProduct->setOrder($order);
            $order->addProduct($orderProduct);
        });
    }
    
    protected function prepareOrderShippingDetails(CartInterface $cart, OrderInterface $order)
    {
        $cost        = $cart->getShippingMethodCost()->getCost();
        $grossAmount = $this->getCurrencyHelper()->convert($cost->getGrossAmount(), $cost->getCurrency(), $order->getCurrency());
        $taxRate     = $cost->getTaxRate();
        $orderTotal  = $this->orderTotalFactory->createFromSpecifiedValues($grossAmount, $taxRate, $order->getCurrency());
        
        $order->setShippingTotal($orderTotal);
    }
    
    /**
     * @param CartProductInterface $cartProduct
     * @param OrderInterface       $order
     *
     * @return \WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface
     */
    public function prepareOrderProduct(CartProductInterface $cartProduct, OrderInterface $order)
    {
        $orderProduct   = $this->orderProductFactory->create();
        $product        = $cartProduct->getProduct();
        $variant        = $cartProduct->getVariant();
        $sellPrice      = $cartProduct->getSellPrice();
        $baseCurrency   = $sellPrice->getCurrency();
        $targetCurrency = $order->getCurrency();
        
        $grossAmount = $this->getCurrencyHelper()->convert($sellPrice->getFinalGrossAmount(), $baseCurrency, $targetCurrency);
        $netAmount   = $this->getCurrencyHelper()->convert($sellPrice->getFinalNetAmount(), $baseCurrency, $targetCurrency);
        $taxAmount   = $this->getCurrencyHelper()->convert($sellPrice->getFinalTaxAmount(), $baseCurrency, $targetCurrency);
        
        $sellPrice = new Price();
        $sellPrice->setGrossAmount($grossAmount);
        $sellPrice->setNetAmount($netAmount);
        $sellPrice->setTaxAmount($taxAmount);
        $sellPrice->setTaxRate($sellPrice->getTaxRate());
        $sellPrice->setCurrency($targetCurrency);
        
        $orderProduct->setSellPrice($sellPrice);
        $orderProduct->setBuyPrice($product->getBuyPrice());
        $orderProduct->setQuantity($cartProduct->getQuantity());
        $orderProduct->setWeight($cartProduct->getWeight());
        $orderProduct->setVariant($variant);
        $orderProduct->setProduct($product);
        
        return $orderProduct;
    }
}
