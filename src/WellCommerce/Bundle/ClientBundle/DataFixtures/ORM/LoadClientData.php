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
        $email          = 'demo@wellcommerce.org';
        $fakerGenerator = $this->getFakerGenerator();
        $clientGroup    = $this->getReference('client_group');
        $client         = $this->container->get('client.factory')->create();

        $client->getBillingAddress()->setFirstName($fakerGenerator->firstName);
        $client->getBillingAddress()->setLastName($fakerGenerator->lastName);
        $client->getContactDetails()->setEmail($email);
        $client->getContactDetails()->setPhone($fakerGenerator->phoneNumber);
        $client->setDiscount(25);
        $client->setUsername($email);
        $client->setPassword('demo');
        $client->setConditionsAccepted(true);
        $client->setNewsletterAccepted(true);
        $client->setClientGroup($clientGroup);
        $manager->persist($client);

        $manager->flush();
    }
}
