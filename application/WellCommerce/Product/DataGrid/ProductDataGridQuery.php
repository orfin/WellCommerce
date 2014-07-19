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

use Illuminate\Support\Manager;
use WellCommerce\Core\Component\DataGrid\DataGridQueryInterface;

/**
 * Class ProductDataGridQuery
 *
 * @package WellCommerce\Product\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataGridQuery implements DataGridQueryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery(Manager $manager)
    {
        $query = $manager->table('product');
        $query->leftJoin('product_translation', 'product_translation.product_id', '=', 'product.id');
        $query->leftJoin('product_category', 'product_category.product_id', '=', 'product.id');
        $query->leftJoin('category_translation', 'category_translation.category_id', '=', 'product_category.category_id');
        $query->leftJoin('tax', 'product.tax_id', '=', 'tax.id');
        $query->groupBy('product.id');

        return $query;
    }

} 