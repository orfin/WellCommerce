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

namespace WellCommerce\Bundle\ShippingBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\CurrencyBundle\DataFixtures\ORM\LoadCurrencyData;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCost;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;
use WellCommerce\Bundle\TaxBundle\DataFixtures\ORM\LoadTaxData;

/**
 * Class LoadShippingData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadShippingMethodData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        $tax      = $this->randomizeSamples('tax', LoadTaxData::$samples);
        $currency = $this->randomizeSamples('currency', LoadCurrencyData::$samples);
        $shops    = new ArrayCollection([$this->getReference('shop')]);
        
        $fedEx = $this->createShippingMethod();
        $fedEx->setCalculator('price_table');
        $fedEx->setTax($tax);
        $fedEx->setCurrency($currency);
        $fedEx->translate($this->container->getParameter('locale'))->setName('FedEx');
        $fedEx->mergeNewTranslations();
        $fedEx->setCosts($this->getShippingCostsCollection($fedEx));
        $fedEx->setShops($shops);
        $manager->persist($fedEx);
        
        $ups = $this->createShippingMethod();
        $ups->setCalculator('price_table');
        $ups->setTax($tax);
        $ups->setCurrency($currency);
        $ups->translate($this->container->getParameter('locale'))->setName('UPS');
        $ups->mergeNewTranslations();
        $ups->setCosts($this->getShippingCostsCollection($ups));
        $fedEx->setShops($shops);
        $manager->persist($ups);
        
        $manager->flush();
        
        $this->setReference('shipping_method_fedex', $fedEx);
        $this->setReference('shipping_method_ups', $ups);
    }
    
    private function getShippingCostsCollection(ShippingMethodInterface $shippingMethod)
    {
        $collection = new ArrayCollection();
        
        $cost = new ShippingMethodCost();
        $cost->setRangeFrom(0);
        $cost->setRangeTo(100000);
        
        $price = new Price();
        $price->setCurrency('EUR');
        $price->setNetAmount(10);
        $price->setTaxAmount(2.3);
        $price->setTaxRate(23);
        $price->setGrossAmount(12.3);
        
        $cost->setCost($price);
        $cost->setShippingMethod($shippingMethod);
        $collection->add($cost);
        
        return $collection;
    }
    
    private function createShippingMethod(): ShippingMethodInterface
    {
        return $this->container->get('shipping_method.factory')->create();
    }
}
