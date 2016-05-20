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
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

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

        /** @var ProductStatusInterface $bestseller */
        $bestseller = $this->container->get('product_status.factory')->create();
        $bestseller->setSymbol('bestseller');
        $bestseller->translate($this->getDefaultLocale())->setName('Bestsellers');
        $bestseller->translate($this->getDefaultLocale())->setSlug('bestseller');
        $bestseller->translate($this->getDefaultLocale())->setCssClass('bestseller');
        $bestseller->mergeNewTranslations();
        $manager->persist($bestseller);
        $this->addReference('product_status_bestseller', $bestseller);

        /** @var ProductStatusInterface $bestseller */
        $featured = $this->container->get('product_status.factory')->create();
        $featured->setSymbol('featured');
        $featured->translate($this->getDefaultLocale())->setName('Featured');
        $featured->translate($this->getDefaultLocale())->setSlug('featured');
        $featured->translate($this->getDefaultLocale())->setCssClass('featured');
        $featured->mergeNewTranslations();
        $manager->persist($featured);
        $this->addReference('product_status_featured', $featured);

        /** @var ProductStatusInterface $bestseller */
        $novelty = $this->container->get('product_status.factory')->create();
        $novelty->setSymbol('novelty');
        $novelty->translate($this->getDefaultLocale())->setName('New products');
        $novelty->translate($this->getDefaultLocale())->setSlug('novelty');
        $novelty->translate($this->getDefaultLocale())->setCssClass('novelty');
        $novelty->mergeNewTranslations();
        $manager->persist($novelty);
        $this->addReference('product_status_novelty', $novelty);

        /** @var ProductStatusInterface $bestseller */
        $promotion = $this->container->get('product_status.factory')->create();
        $promotion->setSymbol('promotion');
        $promotion->translate($this->getDefaultLocale())->setName('Promotions');
        $promotion->translate($this->getDefaultLocale())->setSlug('promotion');
        $promotion->translate($this->getDefaultLocale())->setCssClass('promotion');
        $promotion->mergeNewTranslations();
        $manager->persist($promotion);
        $this->addReference('product_status_promotion', $promotion);

        $manager->flush();
    }
}
