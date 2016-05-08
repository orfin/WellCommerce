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
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Class AbstractRouteGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRouteGenerator implements RouteGeneratorInterface
{
    /**
     * @var array
     */
    protected $defaults;
    
    /**
     * @var array
     */
    protected $options;
    
    /**
     * @var array
     */
    protected $requirements;
    
    /**
     * @var array
     */
    protected $pattern;
    
    /**
     * AbstractRouteGenerator constructor.
     *
     * @param array  $defaults
     * @param array  $requirements
     * @param string $pattern
     * @param array  $options
     */
    public function __construct(array $defaults = [], array $requirements = [], string $pattern, array $options = [])
    {
        $this->defaults     = $defaults;
        $this->options      = $options;
        $this->requirements = $requirements;
        $this->pattern      = $pattern;
    }
    
    public function generate(RouteInterface $resource) : Route
    {
        $this->defaults['id']      = $resource->getIdentifier()->getId();
        $this->defaults['_locale'] = $resource->getLocale();
        
        return new Route(
            $this->getPath($resource),
            $this->defaults,
            $this->requirements,
            $this->options
        );
    }
    
    private function prepareRouteDefaults(RouteInterface $resource)
    {
        $this->defaults['id']      = $resource->getIdentifier()->getId();
        $this->defaults['_locale'] = $resource->getLocale();
    }

    /**
     * Returns a concatenated path
     *
     * @param RouteInterface $resource
     *
     * @return string
     */
    protected function getPath(RouteInterface $resource) : string
    {
        if (strlen($this->pattern)) {
            return $resource->getPath() . RouteGeneratorInterface::PATH_PARAMS_SEPARATOR . $this->pattern;
        }
        
        return $resource->getPath();
    }
}
