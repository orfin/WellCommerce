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

namespace WellCommerce\Tax\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class TaxDataGridQuery
 *
 * @package WellCommerce\Tax\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('tax');
        $qb->join('tax_translation', 'tax_translation.tax_id', '=', 'tax.id');
        $qb->groupBy('tax.id');

        return $qb;
    }
} 