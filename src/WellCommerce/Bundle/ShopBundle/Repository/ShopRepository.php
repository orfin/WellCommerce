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

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class ShopRepository
 *
 * @package WellCommerce\Bundle\ShopBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopRepository extends AbstractEntityRepository implements ShopRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('shop.id');
    }

    /**
     * {@inheritdoc}
     */
    public function updateRow(array $request)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function deleteMultipleRows(array $ids)
    {
        return false;
    }

    public function getShopsToSelect()
    {
        $shops  = $this->findAll();
        $select = [];
        foreach ($shops as $shop) {
            $select[$shop->getId()] = $shop->getName();
        }

        return $select;
    }
}
