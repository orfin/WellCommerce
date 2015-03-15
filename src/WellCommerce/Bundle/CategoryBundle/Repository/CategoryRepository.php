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

namespace WellCommerce\Bundle\CategoryBundle\Repository;

use Symfony\Component\HttpFoundation\ParameterBag;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;
use WellCommerce\Bundle\RoutingBundle\Helper\Sluggable;

/**
 * Class CategoryRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryRepository extends AbstractEntityRepository implements CategoryRepositoryInterface
{
    public function getDataSetQueryBuilder()
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('category.id');
        $queryBuilder->leftJoin('category.translations', 'category_translation');
        $queryBuilder->leftJoin('category.children', 'category_children');
        $queryBuilder->leftJoin('category.products', 'category_products');
        $queryBuilder->leftJoin('category.shops', 'category_shops');

        return $queryBuilder;
    }

    public function changeOrder(array $items = [])
    {
        foreach ($items as $item) {
            $parent = $this->find($item['parent']);
            $child  = $this->find($item['id']);
            if (null !== $child) {
                $child->setParent($parent);
                $child->setHierarchy($item['weight']);
                $this->_em->persist($child);
            }
        }

        $this->_em->flush();
    }

    public function quickAddCategory(ParameterBag $parameters)
    {
        $name     = $parameters->get('name');
        $parent   = $this->find((int) $parameters->get('parent'));
        $locales  = $this->getLocales();
        $category = new Category();
        $category->setHierarchy(0);
        $category->setEnabled(1);
        $category->setParent($parent);

        /** @var $locale \WellCommerce\Bundle\IntlBundle\Entity\Locale */
        foreach ($locales as $locale) {
            $category->translate($locale->getCode())->setName($name);
            $category->translate($locale->getCode())->setSlug(Sluggable::makeSlug($name));
        }
        $category->mergeNewTranslations();
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();

        return $category;
    }
}
