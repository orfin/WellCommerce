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

namespace WellCommerce\Plugin\Cart\Repository;

/**
 * Interface CartRepositoryInterface
 *
 * @package WellCommerce\Plugin\Cart\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartRepositoryInterface
{
    const PRE_DELETE_EVENT  = 'cart.repository.pre_delete';
    const POST_DELETE_EVENT = 'cart.repository.post_delete';
    const PRE_SAVE_EVENT    = 'cart.repository.pre_save';
    const POST_SAVE_EVENT   = 'cart.repository.post_save';

    /**
     * Returns all client carts as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a single cart model
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\Cart\Model\Cart
     */
    public function find($id);

    /**
     * Adds or updates a cart
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a cart
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);
}