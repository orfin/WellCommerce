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

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

/**
 * Class CategoryRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryRepository extends EntityRepository implements CategoryRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('category.id');
        $queryBuilder->leftJoin('category.translations', 'category_translation');
        $queryBuilder->leftJoin('category.children', 'category_children');
        $queryBuilder->leftJoin('category.products', 'category_products');
        $queryBuilder->leftJoin('category.shops', 'category_shops');

        return $queryBuilder;
    }
}
