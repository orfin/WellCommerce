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

/**
 * Interface RedirectHelperInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Helper\Redirect
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RedirectHelperInterface
{
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
}
