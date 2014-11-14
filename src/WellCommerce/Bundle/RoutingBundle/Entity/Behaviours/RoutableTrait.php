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

namespace WellCommerce\Bundle\RoutingBundle\Entity\Behaviours;

use WellCommerce\Bundle\RoutingBundle\Entity\Route;

/**
 * Class RoutableTrait
 *
 * @package WellCommerce\Bundle\RoutingBundle\Entity\Behaviours
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait RoutableTrait
{
    protected $needsFlush = false;

    /**
     * @ORM\OneToOne(targetEntity="WellCommerce\Bundle\RoutingBundle\Entity\Route", mappedBy="id", orphanRemoval=true)
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", onDelete="SET NULL")
     **/
    protected $route;

    /**
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    protected $slug;

    /**
     * Sets the entity's slug.
     *
     * @param $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Returns the entity's slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the entity's route.
     *
     * @param $route
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;
    }

    /**
     * Returns the entity's route.
     *
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }
}