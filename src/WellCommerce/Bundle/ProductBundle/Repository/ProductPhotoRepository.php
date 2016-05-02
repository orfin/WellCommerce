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
namespace WellCommerce\Bundle\ProductBundle\Repository;

use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

/**
 * Class ProductPhotoRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductPhotoRepository extends EntityRepository implements ProductPhotoRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return $this->getQueryBuilder()->groupBy('product.id');
    }
}
