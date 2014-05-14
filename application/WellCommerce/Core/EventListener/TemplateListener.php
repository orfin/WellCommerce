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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Core\Template\TemplateGuesser;

/**
 * Class Template
 *
 * @package WellCommerce\Core\EventListener\TemplateListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TemplateListener implements EventSubscriberInterface
{

    /**
     * @var \WellCommerce\Core\Template\TemplateGuesser
     */
    private $guesser;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     * @param TemplateGuesser    $guesser
     */
    public function __construct(ContainerInterface $container, TemplateGuesser $guesser)
    {
        $this->guesser   = $guesser;
        $this->container = $container;
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

        $request = $event->getRequest();
        $guesser = $this->container->get('template_guesser');
        list($template, $loader) = $guesser->guess($controller, $request);

        $request->attributes->set('_template_name', $template);
        $request->attributes->set('_template_loader', $loader);
        $event->getRequest()->attributes->set('_template_vars', Array());
    }

    /**
     * Called through KernelEvents::VIEW event
     *
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request          = $event->getRequest();
        $controllerResult = $event->getControllerResult();
        $templateVars     = $request->attributes->get('_template_vars');
        $parameters       = array_merge($templateVars, $controllerResult);
        $template         = $request->attributes->get('_template_name');
        $loader           = $this->container->get($request->attributes->get('_template_loader'));
        $twig             = $this->container->get('twig');

        // immediately return controller result if Response object is given
        if ($controllerResult instanceof Response) {
            return $controllerResult;
        }

        // process xajax requests before template rendering
        $this->container->get('xajax')->processRequest();

        $twig->setLoader($loader);
        $response = $twig->render($template, $parameters);
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