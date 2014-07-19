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

namespace WellCommerce\Core\Component\DataGrid\Query;

use Illuminate\Database\Capsule\Manager;

/**
 * Interface QueryInterface
 *
 * @package WellCommerce\Core\Component\DataGrid\Query
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface QueryInterface
{
    /**
     * Sets query manager instance
     *
     * @param Manager $manager
     *
     * @return void
     */
    public function setManager(Manager $manager);

    /**
     * Returns current DataGrid query
     *
     * @return mixed
     */
    public function getQuery();
} 