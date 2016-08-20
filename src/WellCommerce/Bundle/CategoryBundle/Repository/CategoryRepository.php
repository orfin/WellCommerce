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
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('category.id');
        $queryBuilder->leftJoin('category.translations', 'category_translation');
        $queryBuilder->leftJoin('category.shops', 'category_shops');

        return $queryBuilder;
    }

    public function getCategoryPath(CategoryInterface $category) : array
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
}
