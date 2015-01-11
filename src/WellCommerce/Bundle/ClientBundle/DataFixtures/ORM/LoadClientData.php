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

namespace WellCommerce\Bundle\ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\ClientBundle\Entity\Client;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadClientData
 *
 * @package WellCommerce\Bundle\ClientBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadClientData extends AbstractDataFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $clientGroup
            = $manager->getRepository('WellCommerce\Bundle\ClientBundle\Entity\ClientGroup')
            ->findOneBy(['discount' => 10]);

        for ($i = 1; $i <= 100; $i++) {
            $client = new Client();
            $client->setFirstName($this->fakerGenerator->firstName);
            $client->setLastName($this->fakerGenerator->lastName);
            $client->setUsername($this->fakerGenerator->userName.$i);
            $client->setEmail($this->fakerGenerator->email);
            $client->setPhone($this->fakerGenerator->phoneNumber);
            $client->setDiscount(rand(0, 100));
            $client->setPassword(time());
            $client->setGroup($clientGroup);
            $manager->persist($client);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
