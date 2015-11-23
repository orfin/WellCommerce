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

namespace WellCommerce\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\AppBundle\Entity\Unit;
use WellCommerce\AppBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadUnitData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadUnitData extends AbstractDataFixture
{
    public static $samples = ['pcs.', 'set'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::$samples as $name) {
            $unit = new Unit();
            $unit->translate('en')->setName($name);
            $unit->mergeNewTranslations();
            $manager->persist($unit);
            $this->setReference('unit_' . $name, $unit);
        }

        $manager->flush();
    }
}
