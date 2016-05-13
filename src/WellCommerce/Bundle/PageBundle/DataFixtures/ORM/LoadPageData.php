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

namespace WellCommerce\Bundle\PageBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\Helper\Sluggable;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\PageBundle\Entity\Page;
use WellCommerce\Bundle\PageBundle\Entity\PageInterface;

/**
 * Class LoadPageData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadPageData extends AbstractDataFixture
{
    protected $shop;

    protected $defaultText;

    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $this->manager     = $manager;
        $this->shop        = $this->getReference('shop');
        $this->defaultText = $this->getFakerGenerator()->text(600);

        $aboutUs = $this->createPage('About us', 0, null);
        $this->setReference('page_about_us', $aboutUs);
        $this->createPage('News feed', 10, $aboutUs);
        $this->createPage('Stores', 20, $aboutUs);
        $this->createPage('Brands', 30, $aboutUs);
        $this->createPage('Our brand', 40, $aboutUs);
        $this->createPage('About company', 50, $aboutUs);
        $this->createPage('Wholesale', 60, $aboutUs);

        $help = $this->createPage('Help', 10, null);
        $this->setReference('page_help', $aboutUs);
        $this->createPage('Conditions', 10, $help);
        $this->createPage('Returns, warranty', 20, $help);
        $this->createPage('Shipping', 30, $help);
        $this->createPage('Availability & delivery times', 40, $help);
        $this->createPage('Payment', 50, $help);
        $this->createPage('Site map', 60, $help);

        $manager->flush();
    }

    /**
     * Creates a cms page
     *
     * @param string        $name
     * @param int           $hierarchy
     * @param PageInterface $parent
     *
     * @return PageInterface
     */
    protected function createPage($name, $hierarchy, PageInterface $parent = null)
    {
        $page = new Page();
        $page->setParent($parent);
        $page->setHierarchy($hierarchy);
        $page->setPublish(1);
        $page->setRedirectType(0);
        $page->setSection('');
        $page->addShop($this->shop);
        $page->translate($this->getDefaultLocale())->setName($name);
        $page->translate($this->getDefaultLocale())->setSlug(Sluggable::makeSlug($name));
        $page->translate($this->getDefaultLocale())->setContent($this->defaultText);
        $page->mergeNewTranslations();

        $this->manager->persist($page);

        return $page;
    }
}
