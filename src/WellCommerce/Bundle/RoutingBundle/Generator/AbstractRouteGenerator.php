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

use Symfony\Component\Routing\Route as SymfonyRoute;
use WellCommerce\Bundle\RoutingBundle\Entity\Route;

/**
 * Class AbstractRouteGenerator
 *
 * @package WellCommerce\Bundle\RoutingBundle\Generator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRouteGenerator
{
    /**
     * @var
     */
    protected $controller;
    protected $defaults;
    protected $requirements;

    /**
     * Constructor
     *
     * @param       $controller
     * @param array $optionalDefaults
     * @param array $requirements
     */
    public function __construct($controller, array $defaults = [], array $requirements = [])
    {
        $this->controller   = $controller;
        $this->defaults     = $defaults;
        $this->requirements = $requirements;
    }

    public function generate(Route $route)
    {
        $path                         = $route->getStaticPattern();
        $routeDefaults                = $route->getDefaults();
        $routeDefaults['_controller'] = $this->controller;
        foreach ($this->defaults as $key => $value) {
            $routeDefaults[$key] = $value;
            $path .= '/{' . $key . '}';
        }

        return new SymfonyRoute($path, $routeDefaults, $this->requirements);
    }

} 