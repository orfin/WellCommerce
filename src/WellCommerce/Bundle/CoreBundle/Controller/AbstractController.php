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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;

/**
 * Class Controller
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractController extends Controller
{
    /**
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * Constructor
     *
     * @param ManagerInterface $manager
     */
    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Returns content as json response
     *
     * @param mixed $content
     *
     * @return JsonResponse
     */
    protected function jsonResponse($content)
    {
        return new JsonResponse($content);
    }

    /**
     * Translates message using Translator service
     *
     * @param string $id
     *
     * @return string
     */
    protected function trans($id)
    {
        return $this->manager->getTranslator()->trans($id);
    }

    /**
     * Redirects user to another action in scope of current controller
     *
     * @param string $actionName
     * @param array  $params
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToAction($actionName = 'index', array $params = [])
    {
        return $this->manager->getRedirectHelper()->redirectToAction($actionName, $params);
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
        return $this->manager->getRedirectHelper()->getRedirectToActionUrl($actionName, $params);
    }

    /**
     * Renders and displays the template
     *
     * @param string $templateName
     * @param array  $templateVars
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function displayTemplate($templateName, array $templateVars = [])
    {
        $templateResolver = $this->get('template_resolver');
        $template         = $templateResolver->resolveControllerTemplate($this, $templateName);

        return $this->render($template, $templateVars);
    }
}
