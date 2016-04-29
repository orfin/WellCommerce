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
    protected function jsonResponse(array $content) : JsonResponse
    {
        return new JsonResponse($content);
    }

    protected function redirectResponse(string $url, int $status = RedirectResponse::HTTP_FOUND) : RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }

    protected function redirectToAction(string $actionName = 'index', array $params = []) : RedirectResponse
    {
        $url = $this->getRedirectToActionUrl($actionName, $params);

        return $this->redirectResponse($url);
    }

    protected function redirectToRoute(string $routeName, array $routeParams = []) : RedirectResponse
    {
        $url = $this->getRouterHelper()->generateUrl($routeName, $routeParams);

        return $this->redirectResponse($url);
    }

    protected function getRedirectToActionUrl(string $actionName = 'index', array $params = []) : string
    {
        return $this->getRouterHelper()->getRedirectToActionUrl($actionName, $params);
    }

    protected function renderView(string $view, array $parameters = []) : string
    {
        return $this->getTemplatingHelper()->render($view, $parameters);
    }

    protected function displayTemplate(string $templateName, array $templateVars = []) : Response
    {
        return $this->getTemplatingHelper()->renderControllerResponse($this, $templateName, $templateVars);
    }
}
