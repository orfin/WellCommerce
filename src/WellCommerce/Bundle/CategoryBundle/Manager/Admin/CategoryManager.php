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

namespace WellCommerce\Bundle\CategoryBundle\Manager\Admin;

use WellCommerce\Bundle\AdminBundle\Manager\AbstractAdminManager;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\IntlBundle\Entity\Locale;
use WellCommerce\Bundle\IntlBundle\Repository\LocaleRepositoryInterface;
use WellCommerce\Bundle\MultiStoreBundle\Context\ShopContextInterface;
use WellCommerce\Bundle\RoutingBundle\Helper\Sluggable;

/**
 * Class CategoryManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryManager extends AbstractAdminManager
{
    /**
     * @var LocaleRepositoryInterface
     */
    protected $localeRepository;

    /**
     * @var ShopContextInterface
     */
    protected $shopContext;

    /**
     * @var FormBuilderInterface
     */
    protected $treeFormBuilder;

    /**
     * @param LocaleRepositoryInterface $localeRepository
     */
    public function setLocaleRepository(LocaleRepositoryInterface $localeRepository)
    {
        $this->localeRepository = $localeRepository;
    }

    /**
     * @param ShopContextInterface $shopContext
     */
    public function setShopContext(ShopContextInterface $shopContext)
    {
        $this->shopContext = $shopContext;
    }

    /**
     * @param FormBuilderInterface $treeFormBuilder
     */
    public function setTreeFormBuilder(FormBuilderInterface $treeFormBuilder)
    {
        $this->treeFormBuilder = $treeFormBuilder;
    }

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
     * @param int    $parent
     *
     * @return Category
     */
    public function quickAddCategory($name, $parent)
    {
        $em             = $this->getDoctrineHelper()->getEntityManager();
        $currentShop    = $this->shopContext->getCurrentScope();
        $locales        = $this->localeRepository->findAll();
        $parentCategory = $this->getRepository()->find((int)$parent);

        $category = new Category();
        $category->setHierarchy(0);
        $category->setEnabled(1);
        $category->setParent($parentCategory);
        $category->addShop($currentShop);

        foreach ($locales as $locale) {
            $this->translateCategory($locale, $category, $name);
        }

        $em->persist($category);
        $em->flush();

        return $category;
    }

    /**
     * Translates the category
     *
     * @param Locale   $locale
     * @param Category $category
     * @param string   $name
     */
    protected function translateCategory(Locale $locale, Category $category, $name)
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

    /**
     * Returns the tree as a form
     *
     * @return \WellCommerce\Bundle\FormBundle\Elements\FormInterface
     */
    public function getTree()
    {
        return $this->treeFormBuilder->createForm([
            'name'  => 'category_tree',
            'class' => 'category-select',
        ]);
    }
}
