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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;
use WellCommerce\Bundle\CoreBundle\Controller\ControllerInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;

/**
 * Class RouterHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class RouterHelper implements RouterHelperInterface
{
    /**
     * @var RouterInterface
     */
    private $router;
    
    /**
     * @var RequestHelperInterface
     */
    private $requestHelper;
    
    /**
     * RouterHelper constructor.
     *
     * @param RouterInterface        $router
     * @param RequestHelperInterface $requestHelper
     */
    public function __construct(RouterInterface $router, RequestHelperInterface $requestHelper)
    {
        $this->router        = $router;
        $this->requestHelper = $requestHelper;
    }
    
    public function hasControllerAction(ControllerInterface $controller, string $action): bool
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
    
    public function getCurrentAction(): string
    {
        $currentPath  = $this->getRouterRequestContext()->getPathInfo();
        $currentRoute = $this->router->match($currentPath);
        list(, $action) = explode(':', $currentRoute['_controller']);
        
        return $action;
    }
    
    public function getRouterRequestContext(): RequestContext
    {
        return $this->router->getContext();
    }
    
    public function redirectToAction(string $action, array $params = []): RedirectResponse
    {
        $route = $this->getActionForCurrentController($action);
        
        return $this->redirectTo($route, $params);
    }
    
    public function getRedirectToActionUrl(string $action, array $params = []): string
    {
        $route = $this->getActionForCurrentController($action);
        
        return $this->router->generate($route, $params, true);
    }
    
    public function getActionForCurrentController(string $action): string
    {
        $currentPath  = $this->getRouterRequestContext()->getPathInfo();
        $currentRoute = $this->router->match($currentPath);
        list($mode, $controller) = explode('.', $currentRoute['_route'], 3);
        
        $route = sprintf('%s.%s.%s', $mode, $controller, $action);
        
        return $route;
    }
    
    public function generateUrl(string $routeName, array $params = [], int $referenceType = UrlGeneratorInterface::ABSOLUTE_URL): string
    {
        return $this->router->generate($routeName, $params, $referenceType);
    }
    
    public function redirectTo(string $route, array $routeParams = []): RedirectResponse
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
    
    public function getCurrentRoute(): Route
    {
        $routeName = $this->getCurrentRouteName();
        $route     = $this->router->getRouteCollection()->get($routeName);
        
        if (null === $route) {
            throw new NotFoundHttpException('Cannot determine current route from request');
        }
        
        return $route;
    }
    
    public function getCurrentRouteName(): string
    {
        return (string)$this->requestHelper->getAttributesBagParam('_route');
    }
}
