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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
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
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    private $kernel;

    /**
     * Constructor.
     *
     * @param KernelInterface $kernel A KernelInterface instance
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $className  = ClassUtils::getClass($controller[0]);
        $bundle     = $this->getBundleForClass($className);
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

        $event->getRequest()->request->add(['_bundle' => $bundleName]);
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

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -256],
        ];
    }
} 