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

namespace WellCommerce\Bundle\ShopBundle\Repository;

use WellCommerce\Bundle\DoctrineBundle\Repository\AbstractEntityRepository;

/**
 * Class ShopRepository
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopRepository extends AbstractEntityRepository implements ShopRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder()
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('shop.id');
        $queryBuilder->leftJoin('shop.theme', 'shop_theme');
        $queryBuilder->leftJoin('shop.company', 'shop_company');

        return $queryBuilder;
    }
}
