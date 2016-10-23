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
namespace WellCommerce\Bundle\NewsBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;

/**
 * Class NewsRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsRepository extends EntityRepository implements NewsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->leftJoin('news.translations', 'news_translation');
        $queryBuilder->leftJoin('news.photo', 'photos');
        $queryBuilder->groupBy('news.id');
        
        return $queryBuilder;
    }
}
