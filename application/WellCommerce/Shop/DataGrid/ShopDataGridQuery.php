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

namespace WellCommerce\Shop\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class ShopDataGridQuery
 *
 * @package WellCommerce\Shop\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('shop');
        $qb->join('shop_translation', 'shop_translation.shop_id', '=', 'shop.id');
        $qb->groupBy('shop.id');

        return $qb;
    }
} 