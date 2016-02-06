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

namespace WellCommerce\Bundle\DoctrineBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class ResourceEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ResourceEvent extends Event
{
    protected $resource;

    /**
     * Constructor
     *
     * @param object $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Returns current resource
     *
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }
}
