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

namespace WellCommerce\Bundle\ShippingBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use WellCommerce\Bundle\CountryBundle\Repository\CountryRepository;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;
use WellCommerce\Bundle\TaxBundle\Helper\TaxHelper;

/**
 * Class ShippingMethodEventSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ShippingMethodEventSubscriber implements EventSubscriber
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    
    /**
     * ShippingMethodEventSubscriber constructor.
     *
     * @param CountryRepository $countryRepository
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
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
        $entity = $args->getObject();
        if ($entity instanceof ShippingMethodCostInterface) {
            $shippingMethod = $entity->getShippingMethod();
            $cost           = $entity->getCost();
            $grossAmount    = $cost->getGrossAmount();
            $taxRate        = $shippingMethod->getTax()->getValue();
            $netAmount      = TaxHelper::calculateNetPrice($grossAmount, $taxRate);
            
            $cost->setTaxRate($taxRate);
            $cost->setTaxAmount($grossAmount - $netAmount);
            $cost->setNetAmount($netAmount);
            $cost->setCurrency($shippingMethod->getCurrency()->getCode());
        }
        
        if ($entity instanceof ShippingMethodInterface) {
            $availableCountries = $this->countryRepository->all();
            $countries          = array_filter($entity->getCountries(), function ($k) use ($availableCountries) {
                return array_key_exists($k, $availableCountries);
            }, ARRAY_FILTER_USE_KEY);
            
            $entity->setCountries($countries);
        }
    }
    
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }
}
