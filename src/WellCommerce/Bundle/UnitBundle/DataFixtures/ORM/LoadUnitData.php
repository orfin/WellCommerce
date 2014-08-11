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

namespace WellCommerce\Bundle\UnitBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\UnitBundle\Entity\Unit;

/**
 * Class LoadUnitData
 *
 * @package WellCommerce\Bundle\UnitBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadUnitData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $unit = new Unit();
        $unit->translate('pl')->setName('szt');
        $unit->translate('en')->setName('pcs');
        $unit->translate('de')->setName('pcs');
        $unit->translate('fr')->setName('pcs');
        $unit->mergeNewTranslations();

        $manager->persist($unit);
        $manager->flush();
    }
}