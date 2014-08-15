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

use WellCommerce\Bundle\CoreBundle\DataGrid\Request\Request;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class CategoryRepository
 *
 * @package WellCommerce\Bundle\CategoryBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryRepository extends AbstractEntityRepository implements CategoryRepositoryInterface
{
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
            category_translation.name
        ');
        $queryBuilder->leftJoin(
            'WellCommerceCategoryBundle:Category',
            'category_children',
            'WITH',
            'category.parent = category_children.id');
        $queryBuilder->leftJoin(
            'WellCommerceCategoryBundle:CategoryTranslation',
            'category_translation',
            'WITH',
            'category.id = category_translation.translatable AND category_translation.locale = :locale');
        $queryBuilder->groupBy('category.id');
        $queryBuilder->setParameter('locale', $this->getCurrentLocale());
        $query = $queryBuilder->getQuery();
        $items = $query->getArrayResult();

        $categoriesTree = [];
        foreach ($items as $item) {
            $categoriesTree[$item['id']] = [
                'id'          => $item['id'],
                'name'        => $item['name'],
                'hasChildren' => (bool)$item['children'],
                'parent'      => $item['parent'],
                'weight'      => $item['hierarchy']
            ];
        }

        return $categoriesTree;
    }

    public function changeOrder(array $items = [])
    {
        foreach ($items as $item) {
            if ($item['parent'] > 0) {
                $parent = $this->find($item['parent']);
                $child  = $this->find($item['id']);
                $child->setId($item['id']);
                $child->setChildNodeOf($parent);
                $this->_em->persist($child);
            }
        }

        $this->_em->flush();

        die();
    }

}
