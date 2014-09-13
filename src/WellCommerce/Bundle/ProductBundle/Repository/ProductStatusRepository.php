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
 * Class ProductStatusRepository
 *
 * @package WellCommerce\Bundle\ProductBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusRepository extends AbstractEntityRepository implements ProductStatusRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->groupBy('product_status.id')
            ->leftJoin(
                'WellCommerce\Bundle\ProductBundle\Entity\ProductStatusTranslation',
                'product_status_translation',
                'WITH',
                'product_status.id = product_status_translation.translatable AND product_status_translation.locale = :locale');

    }
}
