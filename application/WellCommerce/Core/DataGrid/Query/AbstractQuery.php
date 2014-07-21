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

namespace WellCommerce\Core\DataGrid\Query;

use Illuminate\Database\Capsule\Manager;

/**
 * Class AbstractQuery
 *
 * @package WellCommerce\Core\DataGrid\Query
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractQuery
{
    /**
     * @var \Illuminate\Database\Capsule\Manager
     */
    private $manager;

    /**
     * Constructor
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Returns database manager instance
     *
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }
} 