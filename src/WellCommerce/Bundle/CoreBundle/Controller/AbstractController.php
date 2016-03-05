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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class AbstractController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractController extends AbstractContainerAware implements ControllerInterface
{
    /**
     * Returns content as json response
     *
     * @param array $content
     *
     * @return JsonResponse
     */
    protected function jsonResponse(array $content)
    {
        return new JsonResponse($content);
    }

    /**
     * Redirect to another url
     *
     * @param string $url
     * @param int    $status
     *
     * @return RedirectResponse
     */
    protected function redirectResponse($url, $status = RedirectResponse::HTTP_FOUND)
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * Redirects user to another action of current controller
     *
     * @param string $actionName
     * @param array  $params
     *
     * @return RedirectResponse
     */
    protected function redirectToAction($actionName = 'index', array $params = [])
    {
        $url = $this->getRedirectToActionUrl($actionName, $params);

        return $this->redirectResponse($url);
    }

    /**
     * Redirects to URL generated for route
     *
     * @param string $routeName
     * @param array  $routeParams
     *
     * @return RedirectResponse
     */
    protected function redirectToRoute($routeName, array $routeParams = [])
    {
        $url = $this->getRouterHelper()->generateUrl($routeName, $routeParams);

        return $this->redirectResponse($url);
    }

    /**
     * Creates absolute url pointing to particular controller action
     *
     * @param string $actionName
     * @param array  $params
     *
     * @return string
     */
    protected function getRedirectToActionUrl($actionName = 'index', array $params = [])
    {
        return $this->getRouterHelper()->getRedirectToActionUrl($actionName, $params);
    }

    /**
     * Returns a rendered view.
     *
     * @param string $view       The view name
     * @param array  $parameters An array of parameters to pass to the view
     *
     * @return string The rendered view
     */
    protected function renderView($view, array $parameters = [])
    {
        return $this->getTemplatingHelper()->render($view, $parameters);
    }

    /**
     * Renders and displays the template
     *
     * @param string $templateName
     * @param array  $templateVars
     *
     * @return Response
     */
    protected function displayTemplate($templateName, array $templateVars = [])
    {
        return $this->getTemplatingHelper()->renderControllerResponse($this, $templateName, $templateVars);
    }
}
