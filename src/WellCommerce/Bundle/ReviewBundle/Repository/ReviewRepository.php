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

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class ReviewRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewRepository extends EntityRepository implements ReviewRepositoryInterface
{
    public function getProductReviews(ProductInterface $product): Collection
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->eq('product', $product));
        $criteria->andWhere($criteria->expr()->eq('enabled', true));
        $criteria->orderBy([
            'ratio' => 'desc',
            'likes' => 'asc',
        ]);
        
        return $this->matching($criteria);
    }
    
    public function getAlias(): string
    {
        return 'reviews';
    }
}
