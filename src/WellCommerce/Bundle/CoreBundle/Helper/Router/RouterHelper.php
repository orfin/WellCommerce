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

namespace WellCommerce\Bundle\CoreBundle\Helper\Router;

use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;

/**
 * Class RouterHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouterHelper implements RouterHelperInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * Constructor
     *
     * @param RouterInterface        $router
     * @param RequestHelperInterface $requestHelper
     */
    public function __construct(RouterInterface $router, RequestHelperInterface $requestHelper)
    {
        $this->router        = $router;
        $this->requestHelper = $requestHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function hasControllerAction($controller, $action)
    {
        $reflectionClass = new ReflectionClass($controller);
        if ($reflectionClass->hasMethod($action)) {
            $reflectionMethod = new ReflectionMethod($controller, $action);
            if ($reflectionMethod->isPublic()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentAction()
    {
        $currentPath  = $this->getRouterRequestContext()->getPathInfo();
        $currentRoute = $this->router->match($currentPath);
        list(, $action) = explode(':', $currentRoute['_controller']);

        return $action;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouterRequestContext()
    {
        return $this->router->getContext();
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToAction($action, array $params = [])
    {
        $route = $this->getActionForCurrentController($action);

        return $this->redirectTo($route, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectToActionUrl($action, array $params = [])
    {
        $route = $this->getActionForCurrentController($action);

        return $this->router->generate($route, $params, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getActionForCurrentController($action)
    {
        $currentPath  = $this->getRouterRequestContext()->getPathInfo();
        $currentRoute = $this->router->match($currentPath);
        list($mode, $controller) = explode('.', $currentRoute['_route'], 3);

        $route = sprintf('%s.%s.%s', $mode, $controller, $action);

        return $route;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUrl($routeName, array $routeParams = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_URL)
    {
        return $this->router->generate($routeName, $routeParams, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function redirectTo($route, array $routeParams = [])
    {
        $url      = $this->router->generate($route, $routeParams, true);
        $response = new RedirectResponse($url);
        $response->setContent(
            sprintf(
                '<!DOCTYPE html><html><head></head><script>window.location.href = "%s";</script></html>',
                htmlspecialchars($url, ENT_QUOTES, 'UTF-8')
            )
        );

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentRoute()
    {
        $routeName = $this->requestHelper->getAttributesBagParam('_route');
        $route     = $this->router->getRouteCollection()->get($routeName);
        if (null === $route) {
            throw new \RuntimeException('Cannot determine current route from request');
        }

        return $this->router->getRouteCollection()->get($routeName);
    }
}
