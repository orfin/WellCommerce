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

namespace WellCommerce\Plugin\Shop\Repository;

/**
 * Interface ShopRepositoryInterface
 *
 * @package WellCommerce\Plugin\Shop\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShopRepositoryInterface
{
    const PRE_DELETE_EVENT           = 'shop.repository.pre_delete';
    const POST_DELETE_EVENT          = 'shop.repository.post_delete';
    const PRE_SAVE_EVENT             = 'shop.repository.pre_save';
    const POST_SAVE_EVENT            = 'shop.repository.post_save';
    const PRE_UPDATE_DATAGRID_EVENT  = 'shop.repository.pre_datagrid_save';
    const POST_UPDATE_DATAGRID_EVENT = 'shop.repository.post_datagrid_save';

    /**
     * Returns all shops as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a shop model
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\Shop\Model\Shop
     */
    public function find($id);

    /**
     * Adds or updates a shop
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a shop
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Saves basic shop values directly from DataGrid
     *
     * @param array $request
     *
     * @return array
     */
    public function updateDataGridRow(array $request);
}