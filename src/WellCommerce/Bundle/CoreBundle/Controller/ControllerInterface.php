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

namespace WellCommerce\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ControllerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ControllerInterface
{
    /**
     * Returns content as json response
     *
     * @param array $content
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function jsonResponse(array $content);

    /**
     * Redirect to another url
     *
     * @param string $url
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectResponse($url, $status = RedirectResponse::HTTP_OK);

    /**
     * Redirects user to another action of current controller
     *
     * @param string $actionName
     * @param array  $params
     *
     * @return RedirectResponse
     */
    public function redirectToAction($actionName = 'index', array $params = []);

    /**
     * Redirects to URL generated for route
     *
     * @param string $routeName
     * @param array  $routeParams
     *
     * @return RedirectResponse
     */
    public function redirectToRoute($routeName, array $routeParams = []);

    /**
     * Creates absolute url pointing to particular controller action
     *
     * @param string $actionName
     * @param array  $params
     *
     * @return string
     */
    public function getRedirectToActionUrl($actionName = 'index', array $params = []);

    /**
     * Renders a view.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = [], Response $response = null);

    /**
     * Returns a rendered view.
     *
     * @param string $view       The view name
     * @param array  $parameters An array of parameters to pass to the view
     *
     * @return string The rendered view
     */
    public function renderView($view, array $parameters = []);

    /**
     * Renders and displays the template
     *
     * @param string $templateName
     * @param array  $templateVars
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayTemplate($templateName, array $templateVars = []);
}
