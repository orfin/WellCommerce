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

namespace WellCommerce\FileManager\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class FileManagerDataGridQuery
 *
 * @package WellCommerce\File\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileManagerDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('file');
        $qb->groupBy('file.id');

        return $qb;
    }
} 