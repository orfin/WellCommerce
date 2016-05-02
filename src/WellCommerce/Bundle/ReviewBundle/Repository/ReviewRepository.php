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
namespace WellCommerce\Bundle\ReviewBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

/**
 * Class ReviewRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewRepository extends EntityRepository implements ReviewRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('review.id');
        $queryBuilder->leftJoin('review.product', 'product_info');
        $queryBuilder->leftJoin('product_info.translations', 'product_translation');

        return $queryBuilder;
    }
}
