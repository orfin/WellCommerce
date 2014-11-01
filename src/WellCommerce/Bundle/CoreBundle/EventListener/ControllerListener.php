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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class ControllerListener
 *
 * @package WellCommerce\Bundle\CoreBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ControllerListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    private $kernel;

    /**
     * Constructor.
     *
     * @param KernelInterface $kernel A KernelInterface instance
     */
    public function __construct(ContainerInterface $container, KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -256],
            KernelEvents::VIEW       => 'onKernelView',
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $request  = $event->getRequest();
        $template = $this->guessTemplateName($controller, $event->getRequest());
        $request->attributes->set('_template', $template);
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request    = $event->getRequest();
        $parameters = $event->getControllerResult();
        $templating = $this->container->get('templating');

        if (null === $parameters) {
            if (!$vars = $request->attributes->get('_template_vars')) {
                if (!$vars = $request->attributes->get('_template_default_vars')) {
                    return;
                }
            }

            $parameters = array();
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
                return $templating->stream($template, $parameters);
            };

            $event->setResponse(new StreamedResponse($callback));
        }
    }

    public function guessTemplateName($controller, Request $request, $engine = 'twig')
    {
        $className = class_exists('Doctrine\Common\Util\ClassUtils') ? ClassUtils::getClass($controller[0])
            : get_class($controller[0]);

        if (!preg_match('/Controller\\\(.+)Controller$/', $className, $matchController)) {
            throw new \InvalidArgumentException(sprintf('The "%s" class does not look like a controller class (it must be in a "Controller" sub-namespace and the class name must end with "Controller")',
                get_class($controller[0])));
        }
        if (!preg_match('/^(.+)Action$/', $controller[1], $matchAction)) {
            throw new \InvalidArgumentException(sprintf('The "%s" method does not look like an action method (it does not end with Action)',
                $controller[1]));
        }

        $bundle = $this->getBundleForClass($className);

        if ($bundle) {
            while ($bundleName = $bundle->getName()) {
                if (null === $parentBundleName = $bundle->getParent()) {
                    $bundleName = $bundle->getName();

                    break;
                }

                $bundles = $this->kernel->getBundle($parentBundleName, false);
                $bundle  = array_pop($bundles);
            }
        } else {
            $bundleName = null;
        }

        return new TemplateReference($bundleName, $matchController[1], $matchAction[1], $request->getRequestFormat(),
            $engine);
    }

    protected function getBundleForClass($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $bundles         = $this->kernel->getBundles();

        do {
            $namespace = $reflectionClass->getNamespaceName();
            foreach ($bundles as $bundle) {
                if (0 === strpos($namespace, $bundle->getNamespace())) {
                    return $bundle;
                }
            }
            $reflectionClass = $reflectionClass->getParentClass();
        } while ($reflectionClass);
    }
} 