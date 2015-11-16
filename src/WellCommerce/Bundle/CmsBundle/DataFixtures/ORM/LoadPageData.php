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

namespace WellCommerce\Bundle\CmsBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CmsBundle\Entity\Page;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\CommonBundle\Helper\Sluggable;

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
        $this->manager     = $manager;
        $this->shop        = $this->getReference('shop');
        $this->defaultText = $this->getFakerGenerator()->text(600);

        $aboutUs = $this->createPage('About us', 0, null);
        $this->createPage('News feed', 10, $aboutUs);
        $this->createPage('Stores', 20, $aboutUs);
        $this->createPage('Brands', 30, $aboutUs);
        $this->createPage('Our brand', 40, $aboutUs);
        $this->createPage('About company', 50, $aboutUs);
        $this->createPage('Wholesale', 60, $aboutUs);

        $help = $this->createPage('Help', 10, null);
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
     * @param string $name
     * @param int    $hierarchy
     * @param Page   $parent
     *
     * @return Page
     */
    protected function createPage($name, $hierarchy, Page $parent = null)
    {
        $page = new Page();
        $page->setParent($parent);
        $page->setHierarchy($hierarchy);
        $page->setPublish(1);
        $page->setRedirectType(0);
        $page->addShop($this->shop);
        $page->translate('en')->setName($name);
        $page->translate('en')->setSlug(Sluggable::makeSlug($name));
        $page->translate('en')->setContent($this->defaultText);
        $page->mergeNewTranslations();

        $this->manager->persist($page);

        return $page;
    }
}
