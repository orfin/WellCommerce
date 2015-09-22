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

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\TaxBundle\Helper\TaxHelper;

/**
 * Class CurrencySubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            'product.pre_create' => ['onProductSave', 0],
            'product.pre_update' => ['onProductSave', 0],
        ];
    }

    public function onProductSave(ResourceEvent $event)
    {
        if (($product = $event->getResource()) instanceof ProductInterface) {
            $this->refreshProductSellPrices($product);
            $this->refreshProductBuyPrices($product);
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
}
