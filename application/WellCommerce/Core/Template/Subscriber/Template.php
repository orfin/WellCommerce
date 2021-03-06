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
namespace WellCommerce\Core\Template\Subscriber;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Core\Template\Guesser\AdminTemplateGuesser;
use WellCommerce\Core\Template\Guesser\FrontendTemplateGuesser;

/**
 * Class Template
 *
 * @package WellCommerce\Core\Template\Subscriber
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Template implements EventSubscriberInterface
{

    /**
     * @var string
     */
    protected $engine = 'twig';

    /**
     * Called through KernelEvents::CONTROLLER event
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
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
         * Fetch Service Container
         */
        $container = $event->getDispatcher()->getContainer();

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
        $container->get('xajax')->processRequest();

        $parameters['xajax'] = $container->get('xajax')->getJavascript();

        /*
         * Guess template name
         */
        $guesser  = $this->getGuesser($mode);
        $template = $guesser->guess($controller, $action, $event->getRequestType());
        $container->get($this->engine)->setLoader($container->get($this->getTemplateLoaderServiceName($mode)));
        $response = $container->get($this->engine)->render($template, $parameters);

        $event->setResponse(new Response($response));
    }

    /**
     * Resolves template loader service name
     *
     * @param $mode
     *
     * @return string
     */
    protected function getTemplateLoaderServiceName($mode)
    {
        return ('admin' === $mode) ? 'twig.loader.admin' : 'twig.loader.front';
    }

    /**
     * Resolves guesser
     *
     * @param $mode
     *
     * @return AdminTemplateGuesser|FrontendTemplateGuesser
     */
    protected function getGuesser($mode)
    {
        return ('admin' === $mode) ? new AdminTemplateGuesser() : new FrontendTemplateGuesser();
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