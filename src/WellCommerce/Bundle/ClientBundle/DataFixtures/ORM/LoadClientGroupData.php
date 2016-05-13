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
use WellCommerce\Bundle\ClientBundle\Entity\ClientGroup;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadClientGroupData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadClientGroupData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $clientGroup = new ClientGroup();
        $clientGroup->setDiscount(10);
        $clientGroup->translate($this->getDefaultLocale())->setName('Default client group');
        $clientGroup->mergeNewTranslations();
        $manager->persist($clientGroup);
        $manager->flush();

        $this->setReference('client_group', $clientGroup);
    }
}
