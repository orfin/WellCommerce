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
     * {@inheritdoc}
     */
    public function jsonResponse(array $content)
    {
        return new JsonResponse($content);
    }

    /**
     * {@inheritdoc}
     */
    public function redirectResponse($url, $status = RedirectResponse::HTTP_FOUND)
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToAction($actionName = 'index', array $params = [])
    {
        $url = $this->getRedirectToActionUrl($actionName, $params);

        return $this->redirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToRoute($routeName, array $routeParams = [])
    {
        $url = $this->getRouterHelper()->generateUrl($routeName, $routeParams);

        return $this->redirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectToActionUrl($actionName = 'index', array $params = [])
    {
        return $this->getRouterHelper()->getRedirectToActionUrl($actionName, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function render($view, array $parameters = [], Response $response = null)
    {
        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function renderView($view, array $parameters = [])
    {
        return $this->container->get('templating')->render($view, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function displayTemplate($templateName, array $templateVars = [])
    {
        $templating       = $this->container->get('templating');
        $templateResolver = $this->get('template_resolver');
        $template         = $templateResolver->resolveControllerTemplate($this, $templateName);

        return $templating->renderResponse($template, $templateVars);
    }
}
