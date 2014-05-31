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

namespace WellCommerce\Plugin\Deliverer\Repository;

/**
 * Interface DelivererRepositoryInterface
 *
 * @package WellCommerce\Plugin\Deliverer\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DelivererRepositoryInterface
{
    const PRE_DELETE_EVENT  = 'deliverer.repository.pre_delete';
    const POST_DELETE_EVENT = 'deliverer.repository.post_delete';
    const PRE_SAVE_EVENT    = 'deliverer.repository.pre_save';
    const POST_SAVE_EVENT   = 'deliverer.repository.post_save';

    /**
     * Returns all deliverers as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a deliverer model
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\Deliverer\Model\Deliverer
     */
    public function find($id);

    /**
     * Adds or updates a deliverer
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a deliverer
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
    public function getAllDelivererToSelect();
}