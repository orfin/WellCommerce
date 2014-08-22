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
 * Class ProductRepository
 *
 * @package WellCommerce\Bundle\ProductBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductRepository extends AbstractEntityRepository implements ProductRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('product.id')
            ->leftJoin(
                'WellCommerce\Bundle\ProductBundle\Entity\ProductTranslation',
                'product_translation',
                'WITH',
                'product.id = product_translation.translatable AND product_translation.locale = :locale');

    }
}
