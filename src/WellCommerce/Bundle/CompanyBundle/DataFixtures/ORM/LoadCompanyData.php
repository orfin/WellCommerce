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

namespace WellCommerce\Bundle\CompanyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadCompanyData
 *
 * @package WellCommerce\Bundle\CompanyBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadCompanyData extends AbstractDataFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 10; $i++) {
            echo $this->fakerGenerator->company.PHP_EOL;
        }
        die();

        $this->fakerGenerator->company;

        $company = new Company();
        $company->setName('Your Company Inc.');
        $company->setShortName('Company');
        $company->setCountry('US');
        $company->setStreet('E-Commerce Blvd.');
        $company->setStreetNo('111');
        $company->setFlatNo('22');
        $company->setPostCode('00000');
        $company->setCity('Los Angeles');
        $manager->persist($company);
        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }
}