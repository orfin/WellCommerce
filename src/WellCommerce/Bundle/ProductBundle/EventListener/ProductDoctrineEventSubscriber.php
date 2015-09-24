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
        $this->onProductBeforeSave($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->onProductBeforeSave($args);
    }

    public function onProductBeforeSave(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof ProductInterface) {
            $this->refreshProductSellPrices($entity);
            $this->refreshProductBuyPrices($entity);
            $this->syncProductStock($entity);
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
