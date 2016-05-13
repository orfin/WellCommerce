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

namespace WellCommerce\Bundle\ProductStatusBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\Helper\Sluggable;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatus;

/**
 * Class LoadProductStatusData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadProductStatusData extends AbstractDataFixture
{
    public static $samples = ['Promotions', 'New arrivals', 'Featured', 'Bestsellers'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        foreach (self::$samples as $name) {
            $status = new ProductStatus();
            $status->translate($this->getDefaultLocale())->setName($name);
            $status->translate($this->getDefaultLocale())->setSlug($slug = Sluggable::makeSlug($name));
            $status->translate($this->getDefaultLocale())->setCssClass($slug);
            $status->mergeNewTranslations();
            $manager->persist($status);
            $this->addReference('product_status_' . $name, $status);
        }

        $manager->flush();
    }
}
