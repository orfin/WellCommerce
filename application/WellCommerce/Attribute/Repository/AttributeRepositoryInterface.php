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

namespace WellCommerce\Attribute\Repository;

/**
 * Interface AttributeRepositoryInterface
 *
 * @package WellCommerce\Attribute\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeRepositoryInterface
{
    const POST_DELETE_EVENT = 'attribute.repository.post_delete';
    const PRE_SAVE_EVENT    = 'attribute.repository.pre_save';
    const POST_SAVE_EVENT   = 'attribute.repository.post_save';

    /**
     * Returns all companies as a collection
     *
     * @return mixed
     */
    public function all();

    /**
     * Returns single attribute model
     *
     * @param $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Saves new or existing attribute model
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes attribute model
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
    public function getAllAttributeToSelect();

    /**
     * Returns a collection of all attribute groups
     *
     * @return mixed
     */
    public function getAllAttributeGroups();

    /**
     * Adds new attribute group. Used mostly in direct xajax calls
     *
     * @param array $request Data passed through xajax request
     *
     * @return mixed
     */
    public function addAttributeGroup(array $request);
}