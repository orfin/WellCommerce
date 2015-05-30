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

namespace WellCommerce\Bundle\IntlBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\IntlBundle\Entity\Currency;

/**
 * Class LoadCurrencyData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadCurrencyData extends AbstractDataFixture
{
    const SAMPLES = ['EUR', 'USD', 'GBP'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::SAMPLES as $name) {
            $currency = new Currency();
            $currency->setCode($name);
            $manager->persist($currency);

            $this->setReference('currency_' . $name, $currency);
        }

        $manager->flush();

        $this->container->get('currency.importer.ecb')->importExchangeRates();
    }
}
