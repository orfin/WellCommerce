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
use WellCommerce\CommonBundle\Entity\Locale;
use WellCommerce\AppBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadLocaleData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadLocaleData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $currency = $this->getReference('currency_USD');

        $en = new Locale();
        $en->setCode('en');
        $en->setCurrency($currency);
        $manager->persist($en);
        $manager->flush();

        $this->setReference('locale_en', $en);
    }
}
