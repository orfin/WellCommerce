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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\CoreBundle\Helper\Sluggable;

/**
 * Class LoadCategoryData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadCategoryData extends AbstractDataFixture implements FixtureInterface, OrderedFixtureInterface
{
    public static $samples
        = [
            'Smart TVs',
            'Streaming devices',
            'Accessories',
            'DVD & Blue-ray players',
            'Audio players',
            'Projectors',
            'Home theater',
        ];
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        $shop = $this->getReference('shop');
        
        foreach (self::$samples as $hierarchy => $name) {
            $category = new Category();
            $category->setEnabled(true);
            $category->setHierarchy($hierarchy);
            $category->setParent(null);
            $category->setProducts(new ArrayCollection());
            $category->setChildren(new ArrayCollection());
            $category->setChildrenCount(0);
            $category->setProductsCount(0);
            $category->addShop($shop);
            foreach ($this->getLocales() as $locale) {
                $name = sprintf('%s/%s', $locale->getCode(), $name);
                $category->translate($locale)->setName($name);
                $category->translate($locale)->setSlug(Sluggable::makeSlug($name));
                $category->translate($locale)->setShortDescription('');
                $category->translate($locale)->setDescription('');
            }
            $category->mergeNewTranslations();
            $manager->persist($category);
            $this->setReference('category_' . $name, $category);
        }
        
        $manager->flush();
    }
}
