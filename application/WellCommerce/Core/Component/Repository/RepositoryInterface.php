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

namespace WellCommerce\Core\Component\Repository;

/**
 * Interface RepositoryInterface
 *
 * @package WellCommerce\Core\Component\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RepositoryInterface
{

    /**
     * Returns items collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns model by Id
     *
     * @param int $id Id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id);

    /**
     * Deletes model by Id or multiple models if array is passed
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Saves model after form submission
     *
     * @param array $Data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $Data, $id = null);
}