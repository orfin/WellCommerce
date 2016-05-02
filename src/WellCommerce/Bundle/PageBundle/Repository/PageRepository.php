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
namespace WellCommerce\Bundle\PageBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

/**
 * Class PageRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageRepository extends EntityRepository implements PageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->leftJoin('page.translations', 'page_translation');
        $queryBuilder->leftJoin('page.children', 'page_children');
        $queryBuilder->leftJoin('page.shops', 'page_shops');
        $queryBuilder->groupBy('page.id');
        
        return $queryBuilder;
    }
}
