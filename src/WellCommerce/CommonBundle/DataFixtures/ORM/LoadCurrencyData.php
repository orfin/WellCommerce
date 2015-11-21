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

namespace WellCommerce\CommonBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\CommonBundle\Entity\Currency;
use WellCommerce\CoreBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadCurrencyData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadCurrencyData extends AbstractDataFixture
{
    public static $samples = ['EUR', 'USD', 'GBP'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::$samples as $name) {
            $currency = new Currency();
            $currency->setCode($name);
            $manager->persist($currency);

            $this->setReference('currency_' . $name, $currency);
        }

        $manager->flush();

        $this->container->get('currency.importer.ecb')->importExchangeRates();
    }
}
