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

namespace WellCommerce\Bundle\CoreBundle\Event;


use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ResourceEvent
 *
 * @package WellCommerce\Bundle\CoreBundle\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ResourceEvent extends Event
{

    private $resource;
    private $request;

    /**
     * Constructor
     *
     * @param         $resource
     * @param Request $request
     */
    public function __construct($resource, Request $request = null)
    {
        $this->request  = $request;
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

    /**
     * Returns request object passed from manager
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
} 