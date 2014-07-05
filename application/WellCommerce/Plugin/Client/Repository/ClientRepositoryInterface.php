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

namespace WellCommerce\Plugin\Client\Repository;

/**
 * Interface ClientRepositoryInterface
 *
 * @package WellCommerce\Plugin\Client\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientRepositoryInterface
{
    const PRE_DELETE_EVENT      = 'client.repository.pre_delete';
    const POST_DELETE_EVENT     = 'client.repository.post_delete';
    const PRE_SAVE_EVENT        = 'client.repository.pre_save';
    const POST_SAVE_EVENT       = 'client.repository.post_save';
    const LOGIN_SUCCEED         = 'client.login.succeed';
    const ADDRESS_TYPE_BILLING  = 1;
    const ADDRESS_TYPE_SHIPPING = 2;

    /**
     * Returns all clients as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns single client
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\Client\Model\Client
     */
    public function find($id);

    /**
     * Updates existing client or adds a new one
     *
     * @param array $data
     * @param       $id
     *
     * @return void
     */
    public function save(array $data, $id);

    /**
     * Deletes client
     *
     * @param $id
     *
     * @return void
     */
    public function delete($id);

    /**
     * Authorizes the client using given credentials
     *
     * @param array $data
     *
     * @return bool
     */
    public function authProcess(array $data);
}