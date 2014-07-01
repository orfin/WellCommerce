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

namespace WellCommerce\Plugin\Layout\Repository;

/**
 * Interface LayoutRepositoryInterface
 *
 * @package WellCommerce\Plugin\Layout\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutRepositoryInterface
{
    /**
     * Returns all layout pages with column and boxes configuration
     *
     * @return mixed
     */
    public function all();

    /**
     * Returns layout page configuration
     *
     * @param $page
     *
     * @return mixed
     */
    public function find($page);
}