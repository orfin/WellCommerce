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

namespace WellCommerce\Plugin\Producer\Repository;

/**
 * Interface ProducerRepositoryInterface
 *
 * @package WellCommerce\Plugin\Producer\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProducerRepositoryInterface
{
    const PRE_DELETE_EVENT  = 'producer.repository.pre_delete';
    const POST_DELETE_EVENT = 'producer.repository.post_delete';
    const PRE_SAVE_EVENT    = 'producer.repository.pre_save';
    const POST_SAVE_EVENT   = 'producer.repository.post_save';

    /**
     * Returns all producers as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a producer model
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\Producer\Model\Producer
     */
    public function find($id);

    /**
     * Adds or updates a producer
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a producer
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
    public function getAllProducerToSelect();

    /**
     * Returns Collection as ke-value pairs ready to use in datagrid filters
     *
     * @return mixed
     */
    public function getAllProducerToFilter();
}