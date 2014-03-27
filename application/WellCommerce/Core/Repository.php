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
namespace WellCommerce\Core;

use Closure;

/**
 * Class Repository
 *
 * Provides methods needed in all repository classes
 *
 * @package WellCommerce\Core
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class Repository extends Component
{
    /**
     * Wraps callback function into DB transaction
     *
     * @param callable $callback
     *
     * @return mixed
     */
    final protected function transaction(Closure $callback)
    {
        return $this->container->get('database_manager')->getConnection()->transaction($callback);
    }
}