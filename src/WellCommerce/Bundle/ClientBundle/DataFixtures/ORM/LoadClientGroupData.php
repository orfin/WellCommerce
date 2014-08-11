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
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\ClientBundle\Entity\ClientGroup;
use WellCommerce\Bundle\CompanyBundle\Entity\Company;

/**
 * Class LoadClientGroupData
 *
 * @package WellCommerce\Bundle\ClientBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadClientGroupData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $clientGroup = new ClientGroup();
        $clientGroup->setDiscount(10);
        $clientGroup->translate('pl')->setName('Gość');
        $clientGroup->translate('en')->setName('Guest');
        $clientGroup->translate('de')->setName('Gast');
        $clientGroup->translate('fr')->setName('Convié');
        $clientGroup->mergeNewTranslations();

        $manager->persist($clientGroup);
        $manager->flush();
    }
}