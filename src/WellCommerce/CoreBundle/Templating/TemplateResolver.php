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

namespace WellCommerce\CoreBundle\Templating;

use ReflectionClass;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class TemplateResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TemplateResolver implements TemplateResolverInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * Constructor
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveControllerTemplate($class, $templateName)
    {
        $reflectionClass = new ReflectionClass($class);
        $controllerName  = $this->getControllerLogicalName($reflectionClass);
        $bundleName      = $this->getBundleName($reflectionClass);

        return sprintf('%s:%s:%s.html.twig', $bundleName, $controllerName, $templateName);
    }

    /**
     * Returns the controller's logical name
     *
     * @param ReflectionClass $reflectionClass
     *
     * @return string
     */
    protected function getControllerLogicalName(ReflectionClass $reflectionClass)
    {
        $className = $reflectionClass->getName();
        preg_match('/Controller\\\(.+)Controller$/', $className, $matchController);

        return $matchController[1];
    }

    /**
     * Returns the bundle's name
     *
     * @param ReflectionClass $reflectionClass
     *
     * @return string
     */
    protected function getBundleName(ReflectionClass $reflectionClass)
    {
        $currentBundle = $this->getBundleForClass($reflectionClass);

        return $currentBundle->getName();
    }

    /**
     * Returns bundle for particular controller
     *
     * @param ReflectionClass $class
     *
     * @return \Symfony\Component\HttpKernel\Bundle\BundleInterface
     */
    protected function getBundleForClass(ReflectionClass $reflectionClass)
    {
        $bundles = $this->kernel->getBundles();

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
