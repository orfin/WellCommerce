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
use WellCommerce\Bundle\IntlBundle\DataFixtures\ORM\LoadCurrencyData;
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
        $tax      = $this->randomizeSamples('tax', LoadTaxData::$samples);
        $currency = $this->randomizeSamples('currency', LoadCurrencyData::$samples);
        $factory  = $this->container->get('shipping_method.factory');

        $fedEx = $factory->create();
        $fedEx->setCalculator('price_table');
        $fedEx->setTax($tax);
        $fedEx->setCurrency($currency);
        $fedEx->translate('en')->setName('FedEx');
        $fedEx->mergeNewTranslations();
        $manager->persist($fedEx);

        $ups = $factory->create();
        $ups->setCalculator('price_table');
        $ups->setTax($tax);
        $ups->setCurrency($currency);
        $ups->translate('en')->setName('UPS');
        $ups->mergeNewTranslations();
        $manager->persist($ups);

        $manager->flush();
    }
}
