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

namespace WellCommerce\Bundle\AvailabilityBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadAvailabilityData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadAvailabilityData extends AbstractDataFixture
{
    public static $samples = ['24h', '72h', '7-14 days'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        foreach (self::$samples as $name) {
            $availability = $this->get('availability.factory')->create();
            $availability->translate($this->container->getParameter('locale'))->setName($name);
            $availability->mergeNewTranslations();
            $manager->persist($availability);
            $this->setReference('availability_' . $name, $availability);
        }

        $manager->flush();
    }
}
