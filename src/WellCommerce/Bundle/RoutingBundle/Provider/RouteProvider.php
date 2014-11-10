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

namespace WellCommerce\Bundle\RoutingBundle\Routing;

use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Bundle\RoutingBundle\Generator\RouteGeneratorCollection;
use WellCommerce\Bundle\RoutingBundle\Repository\RouteRepositoryInterface;

/**
 * Class RouteProvider
 *
 * @package WellCommerce\Bundle\RoutingBundle\Routing
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteProvider implements RouteProviderInterface
{
    /**
     * @var RouteRepositoryInterface
     */
    private $routeRepository;

    private $generatorCollection;

    /**
     * Constructor
     *
     * @param RouteRepositoryInterface $routeRepository
     */
    public function __construct(
        RouteRepositoryInterface $routeRepository,
        RouteGeneratorCollection $generatorCollection
    ) {
        $this->routeRepository     = $routeRepository;
        $this->generatorCollection = $generatorCollection;
    }

    public function getRouteCollectionForRequest(Request $request)
    {
        $path            = ltrim($request->getPathInfo(), '/');
        $paths           = explode('/', $path);
        $resource        = $this->routeRepository->findOneByStaticPattern(current($paths));
        $route           = $this->generateRouteFromResource($resource);
        $routeCollection = new RouteCollection();

        $routeCollection->add(
            $resource->getId(),
            $route
        );

        return $routeCollection;
    }

    public function getRouteByName($name)
    {
        $resource = $this->routeRepository->find($name);
        if (!$resource) {
            throw new RouteNotFoundException(sprintf('No route found for id "%s"', $name));
        }

        $route = $this->generateRouteFromResource($resource);

        if (null === $route) {
            throw new RouteNotFoundException(sprintf('No matching route found'));
        }

        return $route;
    }

    public function getRoutesByNames($names, $parameters = [])
    {

    }

    public function generateRouteFromResource($resource)
    {
        /**
         * @var \WellCommerce\Bundle\RoutingBundle\Generator\RouteGeneratorInterface $generator
         */
        foreach ($this->generatorCollection as $generator) {
            if ($generator->supports($resource->getStrategy())) {
                return $generator->generate($resource);
            }
        }
    }
}