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

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\ClientBundle\Entity\Client;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadClientData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadClientData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $fakerGenerator = $this->getFakerGenerator();
        $clientGroup    = $this->getReference('client_group');
        
        for ($i = 1; $i <= 10; $i++) {
            $client = new Client();
            $client->setFirstName($fakerGenerator->firstName);
            $client->setLastName($fakerGenerator->lastName);
            $client->setEmail($fakerGenerator->email);
            $client->setPhone($fakerGenerator->phoneNumber);
            $client->setDiscount(25);
            $client->setPassword(time());
            $client->setConditionsAccepted(true);
            $client->setNewsletterAccepted(true);
            $client->setGroup($clientGroup);
            $manager->persist($client);
        }
        
        $manager->flush();
    }
}
