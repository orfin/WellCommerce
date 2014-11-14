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
    public function getLocale();

    public function getTranslatable();

    public function getSlug();

    /**
     * @return \WellCommerce\Bundle\RoutingBundle\Entity\Route
     */
    public function getRoute();

    /**
     * @param Route $route
     *
     * @return void
     */
    public function setRoute(Route $route);

    public function getSluggableFields();

    public function getRouteGeneratorStrategy();
} 