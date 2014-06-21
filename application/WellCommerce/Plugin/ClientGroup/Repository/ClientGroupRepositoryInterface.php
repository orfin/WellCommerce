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

namespace WellCommerce\Plugin\ClientGroup\Repository;

/**
 * Interface ClientGroupRepositoryInterface
 *
 * @package WellCommerce\Plugin\ClientGroup\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientGroupRepositoryInterface
{
    const POST_DELETE_EVENT          = 'client_group.repository.post_delete';
    const PRE_SAVE_EVENT             = 'client_group.repository.pre_save';
    const POST_SAVE_EVENT            = 'client_group.repository.post_save';
    const PRE_UPDATE_DATAGRID_EVENT  = 'client_group.repository.pre_datagrid_save';
    const POST_UPDATE_DATAGRID_EVENT = 'client_group.repository.post_datagrid_save';

    /**
     * Returns all client groups as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a client group model
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\ClientGroup\Model\ClientGroup
     */
    public function find($id);

    /**
     * Adds or updates a client group
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a client group
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Returns Collection as ke-value pairs ready to use in selects
     *
     * @return mixed
     */
    public function getAllClientGroupToSelect();
}