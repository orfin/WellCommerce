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

namespace WellCommerce\Plugin\Attribute\Repository;

/**
 * Interface AttributeGroupRepositoryInterface
 *
 * @package WellCommerce\Plugin\Attribute\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeGroupRepositoryInterface
{
    const POST_DELETE_EVENT = 'attribute_group.repository.post_delete';
    const PRE_SAVE_EVENT    = 'attribute_group.repository.pre_save';
    const POST_SAVE_EVENT   = 'attribute_group.repository.post_save';

    /**
     * Returns all attribute groups as a collection
     *
     * @return mixed
     */
    public function all();

    /**
     * Returns single attribute group model
     *
     * @param $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Saves new or existing attribute group model
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes attribute group model
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Adds new attribute group. Used mostly in direct xajax calls
     *
     * @param array $request Data passed through xajax request
     *
     * @return mixed
     */
    public function addAttributeGroup(array $request);
}