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

namespace WellCommerce\Profiler\Repository;

use Symfony\Component\HttpKernel\Profiler\Profile;

/**
 * Interface ProfilerRepositoryInterface
 *
 * @package WellCommerce\Profiler\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProfilerRepositoryInterface
{
    /**
     * Returns all products as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a product model
     *
     * @param $id
     *
     * @return \WellCommerce\Profiler\Model\Profiler
     */
    public function find($id);

    /**
     * Adds or updates a product
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(Profile $profile);

    /**
     * Deletes a product
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);
}