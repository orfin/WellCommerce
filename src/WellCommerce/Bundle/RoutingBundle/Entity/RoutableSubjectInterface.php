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
 * Interface RoutableSubjectInterface
 *
 * @package WellCommerce\Bundle\RoutingBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RoutableSubjectInterface
{
    /**
     * Returns locale for translation
     *
     * @return mixed
     */
    public function getLocale();

    /**
     * Returns constraint identifier for translation
     *
     * @return mixed
     */
    public function getTranslatable();

    /**
     * Returns slug
     *
     * @return string
     */
    public function getSlug();

    /**
     * Returns a route bound to entity
     *
     * @return Route
     */
    public function getRoute();

    /**
     * @param Route $route
     *
     * @return void
     */
    public function setRoute(Route $route);

    /**
     * Returns strategy name used in route generation
     *
     * @return string
     */
    public function getRouteGeneratorStrategy();
} 