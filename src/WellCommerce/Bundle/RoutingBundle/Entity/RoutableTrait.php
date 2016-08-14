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

namespace WellCommerce\Bundle\RoutingBundle\Entity;

/**
 * Class RoutableTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait RoutableTrait
{
    protected $needsFlush = false;
    
    /**
     * @var string
     */
    protected $slug;
    
    public function getSlug() : string
    {
        return $this->slug;
    }
    
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        if ($this->route instanceof RouteInterface) {
            $this->route->setPath($slug);
        }
    }
    
    public function getRoute()
    {
        return $this->route;
    }
    
    public function hasRoute() : bool
    {
        return $this->route instanceof RouteInterface;
    }
    
    public function setRoute(RouteInterface $route)
    {
        $this->route = $route;
    }
}
