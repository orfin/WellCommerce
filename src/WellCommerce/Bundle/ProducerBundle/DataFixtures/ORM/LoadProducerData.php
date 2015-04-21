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

namespace WellCommerce\Bundle\ProducerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox;

/**
 * Class LoadProducerData
 *
 * @package WellCommerce\Bundle\ProducerBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadProducerData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $producerMenuBox = new LayoutBox();
        $producerMenuBox->setBoxType('ProducerMenuBox');
        $producerMenuBox->setIdentifier('producer.menu.box');
        $producerMenuBox->setSettings([]);
        $producerMenuBox->translate('en')->setName('Producers');
        $producerMenuBox->mergeNewTranslations();
        $manager->persist($producerMenuBox);
        
        $manager->flush();
    }
}
