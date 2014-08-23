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

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class ProductPhotoRepository
 *
 * @package WellCommerce\Bundle\ProductBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductPhotoRepository extends AbstractEntityRepository implements ProductRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->groupBy('product.id');
    }
}
