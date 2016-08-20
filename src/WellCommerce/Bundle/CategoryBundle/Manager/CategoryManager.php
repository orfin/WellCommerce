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

namespace WellCommerce\Bundle\CategoryBundle\Manager;

use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Sluggable;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\LocaleBundle\Entity\Locale;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Class CategoryManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryManager extends AbstractManager
{
    /**
     * Sorts categories passed in request
     *
     * @param array $items
     */
    public function sortCategories(array $items)
    {
        $repository = $this->getRepository();
        $em         = $this->getDoctrineHelper()->getEntityManager();

        foreach ($items as $item) {
            $parent = $repository->find($item['parent']);
            $child  = $repository->find($item['id']);
            if (null !== $child) {
                $child->setParent($parent);
                $child->setHierarchy($item['weight']);
                $em->persist($child);
            }
        }

        $em->flush();
    }

    /**
     * Adds a new category
     *
     * @param string $name
     * @param int $parent
     * @param ShopInterface $shop
     *
     * @return CategoryInterface
     */
    public function quickAddCategory(string $name, int $parent, ShopInterface $shop) : CategoryInterface
    {
        $parentCategory = $this->getRepository()->find($parent);

        /** @var CategoryInterface $category */
        $category = $this->initResource();
        $category->setParent($parentCategory);
        $category->addShop($shop);

        foreach ($this->getLocales() as $locale) {
            $this->translateCategory($locale, $category, $name);
        }
        $em = $this->getDoctrineHelper()->getEntityManager();
        $em->persist($category);
        $em->flush();

        return $category;
    }


    /**
     * Translates the category
     *
     * @param Locale   $locale
     * @param CategoryInterface $category
     * @param string   $name
     */
    protected function translateCategory(Locale $locale, CategoryInterface $category, $name)
    {
        /**
         * @var $translation \WellCommerce\Bundle\CategoryBundle\Entity\CategoryTranslation
         */
        $translation = $category->translate($locale->getCode());
        $slug        = $this->getLocaleSlug($locale, $name);
        $translation->setName($name);
        $translation->setSlug($slug);
        $category->mergeNewTranslations();
    }

    /**
     * Returns category slug
     *
     * @param Locale $locale
     * @param string $categoryName
     *
     * @return mixed|string
     */
    protected function getLocaleSlug(Locale $locale, $categoryName)
    {
        $slug          = Sluggable::makeSlug($categoryName);
        $currentLocale = $this->getRequestHelper()->getCurrentLocale();
        if ($locale->getCode() != $currentLocale) {
            $slug = Sluggable::makeSlug(sprintf('%s-%s', $categoryName, $locale->getCode()));
        }

        return $slug;
    }
}
