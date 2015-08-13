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

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod;
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
        $tax = $this->randomizeSamples('tax', LoadTaxData::$samples);

        $fedEx = new ShippingMethod();
        $fedEx->setEnabled(1);
        $fedEx->setHierarchy(0);
        $fedEx->setCalculator('fixed_price');
        $fedEx->setTax($tax);
        $fedEx->setCurrency('USD');
        $fedEx->translate('en')->setName('FedEx');
        $fedEx->mergeNewTranslations();
        $manager->persist($fedEx);

        $ups = new ShippingMethod();
        $ups->setEnabled(1);
        $ups->setHierarchy(0);
        $ups->setCalculator('fixed_price');
        $ups->setTax($tax);
        $ups->setCurrency('USD');
        $ups->translate('en')->setName('UPS');
        $ups->mergeNewTranslations();
        $manager->persist($ups);

        $manager->flush();
    }
}
