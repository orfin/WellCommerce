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

namespace WellCommerce\Producer\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class ProducerDataGridQuery
 *
 * @package WellCommerce\Producer\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('producer');
        $qb->join('producer_translation', 'producer_translation.producer_id', '=', 'producer.id');
        $qb->groupBy('producer.id');

        return $qb;
    }
} 