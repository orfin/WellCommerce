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
 * Class Query
 *
 * @package WellCommerce\Core\Component\DataGrid\Query
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Query implements QueryInterface
{
    /**
     * @var \Illuminate\Database\Capsule\Manager
     */
    protected $manager;

    /**
     * @var \Illuminate\Database\Query
     */
    protected $query;

    public function setManager(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function setQuery(Query $query)
    {
        $this->query = $query;
    }

    public function getQuery()
    {
        return $this->query;
    }
} 