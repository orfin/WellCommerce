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
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatus;

/**
 * Class LoadProductStatusData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadProductStatusData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        $bestseller = new ProductStatus();
        $bestseller->setSymbol('bestseller');
        foreach ($this->getLocales() as $locale) {
            $bestseller->translate($locale->getCode())->setName('Bestsellers');
            $bestseller->translate($locale->getCode())->setSlug($locale->getCode() . '/' . 'bestseller');
            $bestseller->translate($locale->getCode())->setCssClass('bestseller');
        }
        
        $bestseller->mergeNewTranslations();
        $manager->persist($bestseller);
        $this->addReference('product_status_bestseller', $bestseller);
        
        $featured = new ProductStatus();
        $featured->setSymbol('featured');
        foreach ($this->getLocales() as $locale) {
            $featured->translate($locale->getCode())->setName('Featured');
            $featured->translate($locale->getCode())->setSlug($locale->getCode() . '/' . 'featured');
            $featured->translate($locale->getCode())->setCssClass('featured');
        }
        $featured->mergeNewTranslations();
        $manager->persist($featured);
        $this->addReference('product_status_featured', $featured);
        
        $novelty = new ProductStatus();
        $novelty->setSymbol('novelty');
        foreach ($this->getLocales() as $locale) {
            $novelty->translate($locale->getCode())->setName('New products');
            $novelty->translate($locale->getCode())->setSlug($locale->getCode() . '/' . 'novelty');
            $novelty->translate($locale->getCode())->setCssClass('novelty');
        }
        
        $novelty->mergeNewTranslations();
        $manager->persist($novelty);
        $this->addReference('product_status_novelty', $novelty);
        
        $promotion = new ProductStatus();
        $promotion->setSymbol('promotion');
        foreach ($this->getLocales() as $locale) {
            $promotion->translate($locale->getCode())->setName('Promotions');
            $promotion->translate($locale->getCode())->setSlug($locale->getCode() . '/' . 'promotion');
            $promotion->translate($locale->getCode())->setCssClass('promotion');
        }
        
        $promotion->mergeNewTranslations();
        $manager->persist($promotion);
        $this->addReference('product_status_promotion', $promotion);
        
        $manager->flush();
    }
}
