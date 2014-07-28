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

namespace WellCommerce\Category\Repository;

/**
 * Interface CategoryRepositoryInterface
 *
 * @package WellCommerce\Category\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryRepositoryInterface
{
    const POST_DELETE_EVENT = 'category.repository.post_delete';
    const PRE_SAVE_EVENT    = 'category.repository.pre_save';
    const POST_SAVE_EVENT   = 'category.repository.post_save';

    /**
     * Returns all categories as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a single category model
     *
     * @param $id
     *
     * @return \WellCommerce\Category\Model\Category
     */
    public function find($id);

    /**
     * Returns category model by slug
     *
     * @param      $slug
     * @param null $language
     *
     * @return mixed
     */
    public function findBySlug($slug, $language = null);

    /**
     * Adds or updates a category model
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a category model
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Changes categories order and parent ids
     *
     * @param $request
     *
     * @return mixed
     */
    public function changeCategoryOrder($request);

    /**
     * Quick add a new category using xajax call
     *
     * @param $request
     *
     * @return mixed
     */
    public function quickAddCategory($request);

    /**
     * Returns categories tree
     *
     * @return mixed
     */
    public function getCategoriesTree();

}