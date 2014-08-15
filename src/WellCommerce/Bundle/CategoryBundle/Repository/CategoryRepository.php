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

use Knp\DoctrineBehaviors\ORM\Tree\Tree;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class CategoryRepository
 *
 * @package WellCommerce\Bundle\CategoryBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryRepository extends AbstractEntityRepository implements CategoryRepositoryInterface
{
    use Tree;

    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('category.id');
    }

    /**
     * {@inheritdoc}
     */
    public function updateRow(array $request)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function deleteMultipleRows(array $ids)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getTreeItems()
    {
//        $items = $this->getTree('','t');
//        print_r($items);die();

        $queryBuilder = $this->getFlatTreeQB('', 'category');
        $queryBuilder->select('category.id, category_translation.name');
        $queryBuilder->leftJoin(
            'WellCommerce\Bundle\CategoryBundle\Entity\CategoryTranslation',
            'category_translation',
            'WITH',
            'category.id = category_translation.translatable AND category_translation.locale = :locale');
        $queryBuilder->setParameter('locale', $this->currentLocale);
        $query = $queryBuilder->getQuery();
        $items = $query->getArrayResult();

        print_r($items);
        die();

        $categoriesTree = [];
        foreach ($items as $item) {
            $categoriesTree[$item['id']] = [
                'id'          => $item['id'],
                'name'        => $item['name'],
                'hasChildren' => false,
                'parent'      => null,
                'weight'      => $item['id'],
            ];
        }

        return $categoriesTree;
    }

    public function quickAddCategory(Request $request)
    {
        $name = $request->request->get('name');

        $category = $this->createNew();
        $category->translate()->setName($name);
        $category->mergeNewTranslations();
        $this->_em->persist($category);
        $this->_em->flush();

        return $category;
    }

    public function changeOrder(array $items = [])
    {
        foreach($items as $item){
            if($item['parent'] > 0){
                $parent = $this->find($item['parent']);
                $child = $this->find($item['id']);
                $child->setId($item['id']);
                $child->setChildNodeOf($parent);
                $this->_em->persist($child);
            }
        }

        $this->_em->flush();

        die();
    }

}
