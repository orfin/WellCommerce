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
use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddress;
use WellCommerce\Bundle\ClientBundle\Entity\ClientShippingAddress;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;

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
        if (!$this->isEnabled()) {
            return;
        }

        $email          = 'demo@wellcommerce.org';
        $fakerGenerator = $this->getFakerGenerator();
        $firstName      = $fakerGenerator->firstName;
        $lastName       = $fakerGenerator->lastName;
        $clientGroup    = $this->getReference('client_group');
        $client         = $this->container->get('client.factory')->create();

        $client->getContactDetails()->setFirstName($firstName);
        $client->getContactDetails()->setLastName($lastName);
        $client->getContactDetails()->setEmail($email);
        $client->getContactDetails()->setPhone($fakerGenerator->phoneNumber);

        $client->getClientDetails()->setDiscount(25);
        $client->getClientDetails()->setUsername($email);
        $client->getClientDetails()->setPassword('demo');
        $client->getClientDetails()->setConditionsAccepted(true);
        $client->getClientDetails()->setNewsletterAccepted(true);

        $client->setClientGroup($clientGroup);

        $billingAddress = new ClientBillingAddress();
        $billingAddress->setFirstName($firstName);
        $billingAddress->setLastName($lastName);
        $billingAddress->setStreet($fakerGenerator->streetName);
        $billingAddress->setStreetNo($fakerGenerator->streetSuffix);
        $billingAddress->setFlatNo($fakerGenerator->buildingNumber);
        $billingAddress->setPostCode($fakerGenerator->postcode);
        $billingAddress->setCity($fakerGenerator->city);
        $billingAddress->setCountry($fakerGenerator->countryCode);
        $billingAddress->setVatId(666777888999);
        $billingAddress->setCompanyName($fakerGenerator->company);

        $shippingAddress = new ClientShippingAddress();
        $shippingAddress->setFirstName($firstName);
        $shippingAddress->setLastName($lastName);
        $shippingAddress->setStreet($fakerGenerator->streetName);
        $shippingAddress->setStreetNo($fakerGenerator->streetSuffix);
        $shippingAddress->setFlatNo($fakerGenerator->buildingNumber);
        $shippingAddress->setPostCode($fakerGenerator->postcode);
        $shippingAddress->setCity($fakerGenerator->city);
        $shippingAddress->setCountry($fakerGenerator->countryCode);

        $client->setBillingAddress($billingAddress);
        $client->setShippingAddress($shippingAddress);

        $client->setShop($this->getReference('shop'));

        $manager->persist($client);

        $manager->flush();
    }
}
