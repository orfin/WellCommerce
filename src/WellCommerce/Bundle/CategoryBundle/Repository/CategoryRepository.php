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
use WellCommerce\Bundle\CategoryBundle\Tree\CategoryTreeBuilder;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class CategoryRepository
 *
 * @package WellCommerce\Bundle\CategoryBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryRepository extends AbstractEntityRepository implements CategoryRepositoryInterface
{
//    public function test(){
//        $qb = $this->createQueryBuilder('category');
//        $res = $qb
//            ->select('category, category_translation, products, products_translation')
//            ->leftJoin('category.products', 'products')
//            ->leftJoin('category.translations', 'category_translation')
//            ->leftJoin('products.translations', 'products_translation')
//            ->add('where',$qb->expr()->eq('category_translation.locale', ':locale'))
//            ->setParameter('locale', 'en')
//            ->getQuery()
//            ->getArrayResult();
//        print_r($res);
//        die();
//    }

    public function getCategoriesTree()
    {
        $queryBuilder = $this->getQueryBuilder('category');

        // select columns
        $queryBuilder->select('
            category.id,
            IDENTITY(category.parent) parent,
            COUNT(category_children.id) children,
            category_translation.name,
            category_translation.slug,
            category_translation.locale,
            IDENTITY(category_translation.route) route
        ');

        // category table
        $queryBuilder->leftJoin(
            'WellCommerceCategoryBundle:Category',
            'category_children',
            'WITH',
            'category_children.parent = category.id');

        // category_translation table
        $queryBuilder->leftJoin(
            'WellCommerceCategoryBundle:CategoryTranslation',
            'category_translation',
            'WITH',
            'category.id = category_translation.translatable');
        $queryBuilder->groupBy('category.id');
        $query   = $queryBuilder->getQuery();
        $items   = $query->getArrayResult();
        $builder = new CategoryTreeBuilder($items);

        return $builder->getTree();
    }

    /**
     * {@inheritdoc}
     */
    public function getTreeItems()
    {
        $queryBuilder = $this->getQueryBuilder('category');
        $queryBuilder->select('
            category.id,
            category.hierarchy,
            IDENTITY(category.parent) parent,
            COUNT(category_children.id) children,
            category_translation.name,
            category_translation.slug,
            category_translation.locale
        ');
        $queryBuilder->leftJoin(
            'WellCommerceCategoryBundle:Category',
            'category_children',
            'WITH',
            'category_children.parent = category.id');
        $queryBuilder->leftJoin(
            'WellCommerceCategoryBundle:CategoryTranslation',
            'category_translation',
            'WITH',
            'category.id = category_translation.translatable');
        $queryBuilder->groupBy('category.id');
        $query = $queryBuilder->getQuery();
        $items = $query->getArrayResult();

        $categoriesTree = [];
        foreach ($items as $item) {
            $categoriesTree[$item['id']] = [
                'id'          => $item['id'],
                'name'        => $item['name'],
                'slug'        => $item['slug'],
                'hasChildren' => (bool)($item['children'] > 0),
                'parent'      => $item['parent'],
                'weight'      => $item['hierarchy'],
            ];
        }

        return $categoriesTree;
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
        $parent   = $this->find((int)$parameters->get('parent'));
        $locales  = $this->getLocales();
        $category = new Category();
        $category->setHierarchy(0);
        $category->setParent($parent);

        /** @var $locale \WellCommerce\Bundle\IntlBundle\Entity\Locale */
        foreach ($locales as $locale) {
            $category->translate($locale->getCode())->setName($name);
        }
        $category->mergeNewTranslations();
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();

        return $category;
    }

}
