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

namespace WellCommerce\Bundle\RoutingBundle\Generator;

use WellCommerce\Bundle\RoutingBundle\Entity\Route;

/**
 * Interface RouteGeneratorInterface
 *
 * @package WellCommerce\Bundle\RoutingBundle\Generator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RouteGeneratorInterface
{
    /**
     * Checks whether generator can handle such a type of generation strategy
     *
     * @param $strategy
     *
     * @return mixed
     */
    public function supports($strategy);

    /**
     * Generates real Symfony route using passed resource
     *
     * @param Route $route
     *
     * @return \Symfony\Component\Routing\Route
     */
    public function generate(Route $route);
}