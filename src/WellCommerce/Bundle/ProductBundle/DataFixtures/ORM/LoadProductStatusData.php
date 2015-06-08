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

namespace WellCommerce\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\ProductBundle\Entity\ProductStatus;
use WellCommerce\Bundle\RoutingBundle\Helper\Sluggable;

/**
 * Class LoadProductStatusData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadProductStatusData extends AbstractDataFixture
{
    public static $samples = ['Featured', 'Bestsellers', 'New arrivals'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::$samples as $name) {
            $status = new ProductStatus();
            $status->translate('en')->setName($name);
            $status->translate('en')->setSlug($slug = Sluggable::makeSlug($name));
            $status->translate('en')->setCssClass($slug);
            $status->mergeNewTranslations();
            $manager->persist($status);
            $this->addReference('product_status_' . $name, $status);
        }

        $manager->flush();
    }
}
