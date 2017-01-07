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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;

/**
 * Class CategoryRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryRepository extends EntityRepository implements CategoryRepositoryInterface
{
    public function getCategoryPath(CategoryInterface $category): array
    {
        $collection = new ArrayCollection();
        $collection->add($category);
        $this->addCategoryParent($category->getParent(), $collection);
        
        return array_reverse($collection->toArray());
    }
    
    private function addCategoryParent(CategoryInterface $category = null, Collection $collection)
    {
        if (null !== $category) {
            $collection->add($category);
            $this->addCategoryParent($category->getParent(), $collection);
        }
    }
    
    public function getDataGridFilterOptions(CategoryInterface $parent = null): array
    {
        $options  = [];
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->eq('parent', $parent));
        $categories = $this->matching($criteria);
        $categories->map(function (CategoryInterface $category) use (&$options) {
            $parentCategory = $category->getParent();
            $options[]      = [
                'id'          => $category->getId(),
                'name'        => $category->translate()->getName(),
                'hasChildren' => (bool)$category->getChildren()->count() > 0,
                'parent'      => ($parentCategory instanceof CategoryInterface) ? $parentCategory->getId() : null,
                'weight'      => $category->getHierarchy(),
            ];
        });
        
        return $options;
    }
}
