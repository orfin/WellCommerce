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

namespace WellCommerce\Core\Migration;

/**
 * Interface MigrationInterface
 *
 * @package WellCommerce\Core\Migration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MigrationInterface
{
    /**
     * Action needed to update application
     *
     * @return mixed
     */
    function up();

    /**
     * Action needed to downgrade application
     *
     * @return mixed
     */
    function down();
} 