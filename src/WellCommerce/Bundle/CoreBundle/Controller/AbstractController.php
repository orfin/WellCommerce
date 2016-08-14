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
use WellCommerce\Bundle\CoreBundle\Helper\Validator\ValidatorHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class AbstractController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractController extends AbstractContainerAware implements ControllerInterface
{
    /**
     * @var null|ManagerInterface
     */
    protected $manager;
    
    /**
     * @var null|FormBuilderInterface
     */
    protected $formBuilder;
    
    /**
     * AbstractController constructor.
     *
     * @param ManagerInterface|null     $manager
     * @param FormBuilderInterface|null $formBuilder
     */
    public function __construct(ManagerInterface $manager = null, FormBuilderInterface $formBuilder = null)
    {
        $this->manager     = $manager;
        $this->formBuilder = $formBuilder;
    }
    
    protected function getManager()
    {
        return $this->manager;
    }
    
    protected function getFormBuilder()
    {
        return $this->formBuilder;
    }
    
    protected function createFormDefaultJsonResponse(FormInterface $form) : JsonResponse
    {
        return $this->jsonResponse([
            'valid'      => $form->isValid(),
            'continue'   => $form->isAction('continue'),
            'next'       => $form->isAction('next'),
            'redirectTo' => $this->getRedirectToActionUrl('index'),
            'error'      => $form->getError(),
        ]);
    }
    
    protected function getForm($resource, array $config = []) : FormInterface
    {
        $builder       = $this->getFormBuilder();
        $defaultConfig = [
            'name'              => $this->getManager()->getRepository()->getAlias(),
            'validation_groups' => ValidatorHelperInterface::DEFAULT_VALIDATOR_GROUPS
        ];

        $config = array_merge($defaultConfig, $config);
        
        return $builder->createForm($config, $resource);
    }
    
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
