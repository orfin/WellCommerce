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

namespace WellCommerce\Bundle\CompanyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\LocaleBundle\Entity\Locale;

/**
 * Class LoadLocaleData
 *
 * @package WellCommerce\Bundle\CompanyBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadLocaleData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $pl = new Locale();
        $pl->setCode('pl');
        $manager->persist($pl);

        $en = new Locale();
        $en->setCode('en');
        $manager->persist($en);

        $de = new Locale();
        $de->setCode('de');
        $manager->persist($de);

        $fr = new Locale();
        $fr->setCode('fr');
        $manager->persist($fr);

        $manager->flush();
    }
}