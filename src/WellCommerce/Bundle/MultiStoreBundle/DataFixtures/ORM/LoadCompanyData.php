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

namespace WellCommerce\Bundle\MultiStoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Company;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadCompanyData
 *
 * @package WellCommerce\Bundle\MultiStoreBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadCompanyData extends AbstractDataFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $company = new Company();
            $company->setName($this->fakerGenerator->company.' '.$this->fakerGenerator->companySuffix);
            $company->setShortName($this->fakerGenerator->company);
            $company->setCountry($this->fakerGenerator->countryCode);
            $company->setStreet($this->fakerGenerator->streetName);
            $company->setStreetNo($this->fakerGenerator->streetSuffix);
            $company->setFlatNo($this->fakerGenerator->randomNumber());
            $company->setPostCode($this->fakerGenerator->postcode);
            $company->setCity($this->fakerGenerator->city);
            $manager->persist($company);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 0;
    }
}
