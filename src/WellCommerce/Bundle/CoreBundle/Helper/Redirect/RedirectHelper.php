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

namespace WellCommerce\Bundle\CoreBundle\Helper\Redirect;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RedirectHelper
 *
 * @package WellCommerce\Bundle\CoreBundle\Helper\Redirect
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RedirectHelper implements RedirectHelperInterface
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
     * {@inheritdoc}
     */
    public function redirectTo($route, array $routeParams = [])
    {
        return new RedirectResponse($this->router->generate($route, $routeParams, true));
    }

    /**
     * Returns current router context
     *
     * @return \Symfony\Component\Routing\RequestContext
     */
    private function getRouterContext()
    {
        return $this->router->getContext();
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToAction($action, array $params = [])
    {
        $currentPath  = $this->getRouterContext()->getPathInfo();
        $currentRoute = $this->router->match($currentPath);
        list($mode, $controller) = explode('.', $currentRoute['_route'], 3);

        $route = sprintf('%s.%s.%s', $mode, $controller, $action);

        return $this->redirectTo($route, $params);
    }
} 