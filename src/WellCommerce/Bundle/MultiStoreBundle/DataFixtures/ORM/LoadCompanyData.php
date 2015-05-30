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

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Company;

/**
 * Class LoadCompanyData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadCompanyData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $fakerGenerator = $this->getFakerGenerator();

        $company = new Company();
        $company->setName($fakerGenerator->company . ' ' . $fakerGenerator->companySuffix);
        $company->setShortName($fakerGenerator->company);
        $company->setCountry($fakerGenerator->countryCode);
        $company->setStreet($fakerGenerator->streetName);
        $company->setStreetNo($fakerGenerator->streetSuffix);
        $company->setFlatNo($fakerGenerator->randomNumber());
        $company->setPostCode($fakerGenerator->postcode);
        $company->setCity($fakerGenerator->city);
        $manager->persist($company);
        $manager->flush();

        $this->setReference('company', $company);
    }
}
