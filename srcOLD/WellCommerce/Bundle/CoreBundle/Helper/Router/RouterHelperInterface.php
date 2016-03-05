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

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Interface RouterHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RouterHelperInterface
{
    /**
     * Checks whether controller action is callable
     *
     * @param object $controller
     * @param string $action
     *
     * @return bool
     */
    public function hasControllerAction($controller, $action);

    /**
     * @return string
     */
    public function getCurrentAction();

    /**
     * Returns the current request context
     *
     * @return \Symfony\Component\Routing\RequestContext
     */
    public function getRouterRequestContext();

    /**
     * Redirects user to another resource
     *
     * @param       $route
     * @param array $routeParams
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectTo($route, array $routeParams = []);

    /**
     * Resolves current route and redirects user to given controller action
     *
     * @param       $action
     * @param array $params
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToAction($action, array $params = []);

    /**
     * Resolves route for given action
     *
     * @param $action
     *
     * @return mixed
     */
    public function getActionForCurrentController($action);

    /**
     * Creates absolute url pointing to particular controller action
     *
     * @param string $action
     * @param array  $params
     *
     * @return string
     */
    public function getRedirectToActionUrl($action, array $params = []);

    /**
     * Generates an url
     *
     * @param       $routeName
     * @param array $routeParams
     * @param int   $referenceType
     *
     * @return mixed
     */
    public function generateUrl($routeName, array $routeParams = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_URL);

    /**
     * @return \Symfony\Component\Routing\Route
     */
    public function getCurrentRoute();
}
