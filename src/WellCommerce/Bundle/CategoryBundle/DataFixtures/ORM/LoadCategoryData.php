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

namespace WellCommerce\Bundle\CategoryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\RoutingBundle\Helper\Sluggable;

/**
 * Class LoadCategoryData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadCategoryData extends AbstractDataFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $shop = $manager->getRepository('WellCommerceMultiStoreBundle:Shop')->findOneBy(['name' => 'WellCommerce']);

        foreach ($this->getSampleCategoriesTree() as $hierarchy => $sample) {
            $category = new Category();
            $category->setEnabled(true);
            $category->setHierarchy($hierarchy);
            $category->setParent(null);
            $category->addShop($shop);
            $category->translate('en')->setName($sample['name']);
            $category->translate('en')->setSlug(Sluggable::makeSlug($sample['name']));
            $category->mergeNewTranslations();
            $manager->persist($category);
        }

        $manager->flush();

    }

    /**
     * Sample demo data
     *
     * @return array
     */
    protected function getSampleCategoriesTree()
    {
        return [
            0 => [
                'name' => 'Smart TVs',
            ],
            1 => [
                'name' => 'Streaming devices',
            ],
            2 => [
                'name' => 'Accessories',
            ],
            3 => [
                'name' => 'DVD & Blue-ray players',
            ],
            4 => [
                'name' => 'Audio players',
            ],
            5 => [
                'name' => 'Projectors',
            ],
            6 => [
                'name' => 'Projectors',
            ],
        ];

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 100;
    }
}

