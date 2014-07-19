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

namespace WellCommerce\ShippingMethod\Repository;

/**
 * Interface ShippingMethodRepositoryInterface
 *
 * @package WellCommerce\ShippingMethod\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodRepositoryInterface
{
    const PRE_DELETE_EVENT  = 'shipping_method.repository.pre_delete';
    const POST_DELETE_EVENT = 'shipping_method.repository.post_delete';
    const PRE_SAVE_EVENT    = 'shipping_method.repository.pre_save';
    const POST_SAVE_EVENT   = 'shipping_method.repository.post_save';

    /**
     * Returns all shipping methods as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a shipping method model
     *
     * @param $id
     *
     * @return \WellCommerce\ShippingMethod\Model\ShippingMethod
     */
    public function find($id);

    /**
     * Adds or updates a shipping method
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a shipping method
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
    public function getAllShippingMethodToSelect();
}