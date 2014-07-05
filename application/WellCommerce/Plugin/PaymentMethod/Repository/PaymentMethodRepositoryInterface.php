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

namespace WellCommerce\Plugin\PaymentMethod\Repository;

/**
 * Interface PaymentMethodRepositoryInterface
 *
 * @package WellCommerce\Plugin\PaymentMethod\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodRepositoryInterface
{
    const PRE_DELETE_EVENT  = 'payment_method.repository.pre_delete';
    const POST_DELETE_EVENT = 'payment_method.repository.post_delete';
    const PRE_SAVE_EVENT    = 'payment_method.repository.pre_save';
    const POST_SAVE_EVENT   = 'payment_method.repository.post_save';

    /**
     * Returns all payment methods as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a payment method model
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\PaymentMethod\Model\PaymentMethod
     */
    public function find($id);

    /**
     * Adds or updates a payment method
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a payment method
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
    public function getAllPaymentMethodToSelect();
}