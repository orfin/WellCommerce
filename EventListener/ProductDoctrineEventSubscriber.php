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

namespace WellCommerce\Bundle\ProductBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;
use WellCommerce\Bundle\TaxBundle\Helper\TaxHelper;

/**
 * Class ProductDoctrineEventSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDoctrineEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->onProductDataBeforeSave($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->onProductDataBeforeSave($args);
    }

    public function onProductDataBeforeSave(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof ProductInterface) {
            $this->refreshProductSellPrices($entity);
            $this->refreshProductBuyPrices($entity);
            $this->syncProductStock($entity);
        }

        if ($entity instanceof VariantInterface) {
            $this->refreshProductVariantSellPrice($entity);
        }
    }

    /**
     * Recalculates sell prices for product
     *
     * @param ProductInterface $product
     */
    protected function refreshProductSellPrices(ProductInterface $product)
    {
        $sellPrice             = $product->getSellPrice();
        $grossAmount           = $sellPrice->getGrossAmount();
        $discountedGrossAmount = $sellPrice->getDiscountedGrossAmount();
        $taxRate               = $product->getSellPriceTax()->getValue();
        $netAmount             = TaxHelper::calculateNetPrice($grossAmount, $taxRate);
        $discountedNetAmount   = TaxHelper::calculateNetPrice($discountedGrossAmount, $taxRate);

        $sellPrice->setTaxRate($taxRate);
        $sellPrice->setTaxAmount($grossAmount - $netAmount);
        $sellPrice->setNetAmount($netAmount);
        $sellPrice->setDiscountedTaxAmount($discountedGrossAmount - $discountedNetAmount);
        $sellPrice->setDiscountedNetAmount($discountedNetAmount);
    }

    /**
     * Recalculates sell prices for single product attribute
     *
     * @param VariantInterface $variant
     */
    protected function refreshProductVariantSellPrice(VariantInterface $variant)
    {
        $product               = $variant->getProduct();
        $sellPrice             = $product->getSellPrice();
        $grossAmount           = $this->calculateAttributePrice($variant, $sellPrice->getGrossAmount());
        $discountedGrossAmount = $this->calculateAttributePrice($variant, $sellPrice->getDiscountedGrossAmount());
        $taxRate               = $product->getSellPriceTax()->getValue();
        $netAmount             = TaxHelper::calculateNetPrice($grossAmount, $taxRate);
        $discountedNetAmount   = TaxHelper::calculateNetPrice($discountedGrossAmount, $taxRate);

        $productAttributeSellPrice = $variant->getSellPrice();
        $productAttributeSellPrice->setTaxRate($taxRate);
        $productAttributeSellPrice->setTaxAmount($grossAmount - $netAmount);
        $productAttributeSellPrice->setGrossAmount($grossAmount);
        $productAttributeSellPrice->setNetAmount($netAmount);
        $productAttributeSellPrice->setDiscountedGrossAmount($discountedGrossAmount);
        $productAttributeSellPrice->setDiscountedTaxAmount($discountedGrossAmount - $discountedNetAmount);
        $productAttributeSellPrice->setDiscountedNetAmount($discountedNetAmount);
        $productAttributeSellPrice->setValidFrom($sellPrice->getValidFrom());
        $productAttributeSellPrice->setValidTo($sellPrice->getValidTo());
        $productAttributeSellPrice->setCurrency($sellPrice->getCurrency());
    }

    /**
     * Calculates new amount for attribute
     *
     * @param VariantInterface $variant
     * @param                           $amount
     *
     * @return float
     */
    protected function calculateAttributePrice(VariantInterface $variant, $amount)
    {
        $modifierType  = $variant->getModifierType();
        $modifierValue = $variant->getModifierValue();

        switch ($modifierType) {
            case '+':
                $amount = $amount + $modifierValue;
                break;
            case '-':
                $amount = $amount - $modifierValue;
                break;
            case '%':
                $amount = $amount * ($modifierValue / 100);
                break;
        }

        return round($amount, 2);
    }

    /**
     * Recalculates buy prices for product
     *
     * @param ProductInterface $product
     */
    protected function refreshProductBuyPrices(ProductInterface $product)
    {
        $buyPrice    = $product->getBuyPrice();
        $grossAmount = $buyPrice->getGrossAmount();
        $taxRate     = $product->getBuyPriceTax()->getValue();
        $netAmount   = TaxHelper::calculateNetPrice($grossAmount, $taxRate);

        $buyPrice->setTaxRate($taxRate);
        $buyPrice->setTaxAmount($grossAmount - $netAmount);
        $buyPrice->setNetAmount($netAmount);
    }

    protected function syncProductStock(ProductInterface $product)
    {
        $trackStock = $product->getTrackStock();

        if (true === $trackStock) {
            $product->setEnabled(($product->getStock() > 0));
        }
    }
}
