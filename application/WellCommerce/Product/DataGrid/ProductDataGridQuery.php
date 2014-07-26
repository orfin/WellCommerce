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

namespace WellCommerce\Product\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class ProductDataGridQuery
 *
 * @package WellCommerce\Product\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('product');
        $qb->leftJoin('product_translation', 'product_translation.product_id', '=', 'product.id');
        $qb->leftJoin('product_category', 'product_category.product_id', '=', 'product.id');
        $qb->leftJoin('category_translation', 'category_translation.category_id', '=', 'product_category.category_id');
        $qb->leftJoin('tax', 'product.tax_id', '=', 'tax.id');
        $qb->groupBy('product.id');
        
        return $qb;
    }
} 