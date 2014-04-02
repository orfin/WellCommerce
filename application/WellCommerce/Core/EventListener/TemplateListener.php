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
namespace WellCommerce\Core\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Core\Template\Guesser\AdminTemplateGuesser;
use WellCommerce\Core\Template\Guesser\FrontendTemplateGuesser;
use WellCommerce\Core\Template\TemplateGuesser;
use Twig_LoaderInterface as LoaderInterface;

/**
 * Class Template
 *
 * @package WellCommerce\Core\EventListener\TemplateListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TemplateListener implements EventSubscriberInterface
{

    private $guesser;

    private $adminLoader;

    private $frontLoader;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(TemplateGuesser $guesser, LoaderInterface $adminLoader, LoaderInterface $frontLoader)
    {
        $this->guesser     = $guesser;
        $this->adminLoader = $adminLoader;
        $this->frontLoader = $frontLoader;
    }

    /**
     * Called through KernelEvents::CONTROLLER event
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $request  = $event->getRequest();
        $guesser  = $this->container->get('template_guesser');
        $template = $guesser->guessTemplateName($controller, $request);
        $request->attributes->set('_template', $template);
        $event->getRequest()->attributes->set('_template_vars', Array());
    }

    /**
     * Called through KernelEvents::VIEW event
     *
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        /*
         * Fetch Request object
         */
        $request = $event->getRequest();

        $controller       = $request->attributes->get('_controller');
        $action           = $request->attributes->get('_action');
        $controllerResult = $event->getControllerResult();
        $templateVars     = $request->attributes->get('_template_vars');
        $mode             = $request->attributes->get('_mode');
        $parameters       = array_merge($templateVars, $controllerResult);

        // immediately return controller result if raw response
        if ($controllerResult instanceof Response) {
            return $controllerResult;
        }
        /*
         * Always process Xajax requests
         */
        $this->container->get('xajax')->processRequest();

        $parameters['xajax'] = $this->container->get('xajax')->getJavascript();

        /*
         * Guess template name
         */
        $guesser  = $this->getGuesser($mode);
        $template = $guesser->guess($controller, $action, $event->getRequestType());
        $this->container->get($this->engine)->setLoader($this->container->get($this->getTemplateLoaderServiceName($mode)));
        $response = $this->container->get($this->engine)->render($template, $parameters);

        $event->setResponse(new Response($response));
    }

    /**
     * Returns subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => array(
                'onKernelController',
                -128
            ),
            KernelEvents::VIEW       => 'onKernelView'
        );
    }
}