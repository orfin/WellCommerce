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

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\Helper\Sluggable;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\ProducerBundle\Entity\Producer;

/**
 * Class LoadProducerData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadProducerData extends AbstractDataFixture
{
    public static $samples = ['LG', 'Samsung', 'Sony', 'Panasonic', 'Toshiba'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $shop = $this->getReference('shop');

        foreach (self::$samples as $name) {
            $producer = new Producer();
            $producer->addShop($shop);
            $producer->translate($this->getDefaultLocale())->setName($name);
            $producer->translate($this->getDefaultLocale())->setSlug(Sluggable::makeSlug($name));
            $producer->mergeNewTranslations();
            $manager->persist($producer);
            $this->setReference('producer_' . $name, $producer);
        }

        $manager->flush();
    }
}
