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

namespace WellCommerce\Bundle\DelivererBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\DelivererBundle\Entity\Deliverer;

/**
 * Class LoadDelivererData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadDelivererData extends AbstractDataFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $deliverer = new Deliverer();
            $name      = $this->fakerGenerator->company;
            $deliverer->translate('pl')->setName($name);
            $deliverer->translate('en')->setName($name);
            $deliverer->mergeNewTranslations();
            $manager->persist($deliverer);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 90;
    }
}
