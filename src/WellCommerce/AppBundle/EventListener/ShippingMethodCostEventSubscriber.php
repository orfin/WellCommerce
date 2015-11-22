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

namespace WellCommerce\AppBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use WellCommerce\AppBundle\Helper\TaxHelper;
use WellCommerce\AppBundle\Entity\ShippingMethodCostInterface;

/**
 * Class ShippingMethodCostEventSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodCostEventSubscriber implements EventSubscriber
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
        $this->onShippingMethodCostBeforeSave($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->onShippingMethodCostBeforeSave($args);
    }

    public function onShippingMethodCostBeforeSave(LifecycleEventArgs $args)
    {
        $range = $args->getObject();
        if ($range instanceof ShippingMethodCostInterface) {
            $shippingMethod = $range->getShippingMethod();
            $cost           = $range->getCost();
            $grossAmount    = $cost->getGrossAmount();
            $taxRate        = $shippingMethod->getTax()->getValue();
            $netAmount      = TaxHelper::calculateNetPrice($grossAmount, $taxRate);

            $cost->setTaxRate($taxRate);
            $cost->setTaxAmount($grossAmount - $netAmount);
            $cost->setNetAmount($netAmount);
            $cost->setCurrency($shippingMethod->getCurrency()->getCode());
        }
    }
}
