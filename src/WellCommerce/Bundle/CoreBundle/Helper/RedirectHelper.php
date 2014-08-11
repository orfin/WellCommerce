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

namespace WellCommerce\Bundle\CoreBundle\Helper;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RedirectHelper
 *
 * @package WellCommerce\Bundle\CoreBundle\Helper
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RedirectHelper
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Redirects user to another resource
     *
     * @param       $route
     * @param array $routeParams
     *
     * @return RedirectResponse
     */
    public function redirectTo($route, array $routeParams = [])
    {
        return new RedirectResponse($this->router->generate($route, $routeParams, true));
    }

    /**
     * Resolves current route and redirects user to given controller action
     *
     * @param $action
     *
     * @return string
     */
    public function redirectToAction($action)
    {
        $currentPath  = $this->router->getContext()->getPathInfo();
        $currentRoute = $this->router->match($currentPath);
        list($mode, $controller) = explode('.', $currentRoute['_route'], 3);

        $route = sprintf('%s.%s.%s', $mode, $controller, $action);

        return $this->redirectTo($route);
    }
} 