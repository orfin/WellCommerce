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

use Symfony\Component\Routing\Route;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Interface RouteGeneratorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RouteGeneratorInterface
{
    const PATH_PARAMS_SEPARATOR = ',';

    /**
     * Checks whether generator can handle such a type of generation strategy
     *
     * @param string $strategy
     *
     * @return bool
     */
    public function supports(string $strategy) : bool;

    /**
     * Generates real Symfony route using given entity
     *
     * @param RouteInterface $entity
     *
     * @return Route
     */
    public function generate(RouteInterface $entity) : Route;
}
