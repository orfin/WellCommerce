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

namespace WellCommerce\Plugin\Category\Repository;

/**
 * Interface CategoryRepositoryInterface
 *
 * @package WellCommerce\Plugin\Category\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryRepositoryInterface
{
    const POST_DELETE_EVENT = 'category.repository.post_delete';
    const PRE_SAVE_EVENT    = 'category.repository.pre_save';
    const POST_SAVE_EVENT   = 'category.repository.post_save';

    /**
     * Returns all categorys as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a category model
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\Category\Model\Category
     */
    public function find($id);

    /**
     * Adds or updates a category
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a category
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);
}