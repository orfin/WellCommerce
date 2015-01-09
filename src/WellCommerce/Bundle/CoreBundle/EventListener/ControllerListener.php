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

namespace WellCommerce\Bundle\CoreBundle\EventListener;

use Doctrine\Common\Util\ClassUtils;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ControllerListener
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ControllerListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container The service container instance
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelView', 128],
        ];
    }

    /**
     * Inherited from TemplateListener
     *
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $event->stopPropagation();
        $request    = $event->getRequest();
        $parameters = $event->getControllerResult();
        $templating = $this->container->get('templating');

        if ($event->getRequestType() == HttpKernelInterface::MASTER_REQUEST) {
            $request->attributes->set('_template_master_vars', $parameters);
        } else {
            $masterParameters = $request->attributes->get('_template_master_vars');
            $parameters       = array_merge($masterParameters, $parameters);
        }

        if (null === $parameters) {
            if (!$vars = $request->attributes->get('_template_vars')) {
                if (!$vars = $request->attributes->get('_template_default_vars')) {
                    return;
                }
            }

            $parameters = [];
            foreach ($vars as $var) {
                $parameters[$var] = $request->attributes->get($var);
            }
        }

        if (!is_array($parameters)) {
            return $parameters;
        }

        if (!$template = $request->attributes->get('_template')) {
            return $parameters;
        }

        if (!$request->attributes->get('_template_streamable')) {
            $event->setResponse($templating->renderResponse($template, $parameters));
        } else {
            $callback = function () use ($templating, $template, $parameters) {
                $templating->stream($template, $parameters);
            };

            $event->setResponse(new StreamedResponse($callback));
        }
    }
}