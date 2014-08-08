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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Repository;

/**
 * Interface DataGridRepositoryInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataGridRepositoryInterface
{
    /**
     * Updates DataGrid row
     *
     * @param array $request
     *
     * @return mixed
     */
    public function updateRow(array $request);

    /**
     * Deletes DataGrid row by its id
     *
     * @param $id
     *
     * @return mixed
     */
    public function deleteRow($id);

    /**
     * Deletes multiple DataGrid rows
     *
     * @param array $ids
     *
     * @return mixed
     */
    public function deleteMultipleRows(array $ids);

    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     * @param string $indexBy The index for the from.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryBuilder($alias, $indexBy = null);
} 