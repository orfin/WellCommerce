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
use WellCommerce\Bundle\ClientBundle\Entity\Role;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox;

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
        $clientGroupRepository = $manager->getRepository('WellCommerce\Bundle\ClientBundle\Entity\ClientGroup');
        $clientGroup           = $clientGroupRepository->findOneBy(['discount' => 10]);

        for ($i = 1; $i <= 100; $i++) {
            $client = new Client();
            $client->setFirstName($this->fakerGenerator->firstName);
            $client->setLastName($this->fakerGenerator->lastName);
            $client->setEmail($this->fakerGenerator->email);
            $client->setPhone($this->fakerGenerator->phoneNumber);
            $client->setDiscount(rand(0, 100));
            $client->setPassword(time());
            $client->setGroup($clientGroup);
            $manager->persist($client);
        }

        $registrationBox = new LayoutBox();
        $registrationBox->setBoxType('ClientRegistrationBox');
        $registrationBox->setIdentifier('client.registration.box');
        $registrationBox->setSettings([]);
        $registrationBox->translate('en')->setName('Client sign-up');
        $registrationBox->mergeNewTranslations();
        $manager->persist($registrationBox);

        $loginBox = new LayoutBox();
        $loginBox->setBoxType('ClientLoginBox');
        $loginBox->setIdentifier('client.login.box');
        $loginBox->setSettings([]);
        $loginBox->translate('en')->setName('Client sign-in');
        $loginBox->mergeNewTranslations();
        $manager->persist($loginBox);

        $orderBox = new LayoutBox();
        $orderBox->setBoxType('ClientOrderBox');
        $orderBox->setIdentifier('client.order.box');
        $orderBox->translate('en')->setName('Client orders');
        $orderBox->mergeNewTranslations();
        $orderBox->setSettings([]);
        $manager->persist($orderBox);

        $settingsBox = new LayoutBox();
        $settingsBox->setBoxType('ClientSettingsBox');
        $settingsBox->setIdentifier('client.settings.box');
        $settingsBox->setSettings([]);
        $settingsBox->translate('en')->setName('Client settings');
        $settingsBox->mergeNewTranslations();
        $manager->persist($settingsBox);

        $forgotPassword = new LayoutBox();
        $forgotPassword->setBoxType('ClientForgotPasswordBox');
        $forgotPassword->setIdentifier('client.forgot_password.box');
        $forgotPassword->setSettings([]);
        $forgotPassword->translate('en')->setName('Password forgotten');
        $forgotPassword->mergeNewTranslations();
        $manager->persist($forgotPassword);

        $addressBook = new LayoutBox();
        $addressBook->setBoxType('ClientAddressBookBox');
        $addressBook->setIdentifier('client.address_book.box');
        $addressBook->setSettings([]);
        $addressBook->translate('en')->setName('Address book');
        $addressBook->mergeNewTranslations();
        $manager->persist($addressBook);

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
