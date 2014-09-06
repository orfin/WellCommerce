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

namespace WellCommerce\Bundle\LayoutBundle\DependencyInjection\Compiler;

use Symfony\Bundle\AsseticBundle\DependencyInjection\DirectoryResourceDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\LogicException;

/**
 * Class TemplateResourcesPass
 *
 * @package WellCommerce\Bundle\LayoutBundle\DependencyInjection\Compiler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * Created on base of the LiipThemeBundle <https://github.com/liip/LiipThemeBundle>
 *
 * Special thanks goes to its authors and contributors
 */
class TemplateResourcesPass implements CompilerPassInterface
{
    private $themes = ['development'];

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('assetic.asset_manager')) {
            return;
        }

        $engines = $container->getParameter('templating.engines');

        $bundles        = $container->getParameter('kernel.bundles');
        $asseticBundles = $container->getParameterBag()->resolveValue($container->getParameter('assetic.bundles'));
        foreach ($asseticBundles as $bundleName) {
            $rc = new \ReflectionClass($bundles[$bundleName]);
            foreach ($engines as $engine) {
                $this->setBundleDirectoryResources($container, $engine, dirname($rc->getFileName()), $bundleName);
            }
        }

        foreach ($engines as $engine) {
            $this->setAppDirectoryResources($container, $engine);
        }
    }

    protected function setBundleDirectoryResources(ContainerBuilder $container, $engine, $bundleDirName, $bundleName)
    {
        if (!$container->hasDefinition('assetic.' . $engine . '_directory_resource.' . $bundleName)) {
            throw new LogicException('The LayoutBundle must be registered after the AsseticBundle in the application Kernel.');
        }
        $definition = 'assetic.' . $engine . '_directory_resource.' . $bundleName;
        $resources  = $container->getDefinition($definition)->getArgument(0);

        foreach ($this->themes as $theme) {
            $resources[] = new DirectoryResourceDefinition(
                $bundleName,
                $engine,
                [
                    $container->getParameter('kernel.root_dir') . '/Resources/' . $bundleName . '/themes/' . $theme,
                    $bundleDirName . '/Resources/themes/' . $theme,
                ]
            );
            echo $bundleDirName.PHP_EOL;
        }

        $container->getDefinition('assetic.' . $engine . '_directory_resource.' . $bundleName)->replaceArgument(0, $resources);
    }

    protected function setAppDirectoryResources(ContainerBuilder $container, $engine)
    {
        if (!$container->hasDefinition('assetic.' . $engine . '_directory_resource.kernel')) {
            throw new LogicException('The LayoutBundle must be registered after the AsseticBundle in the application Kernel.');
        }

        $themes = $this->themes;
        foreach ($themes as $key => $theme) {
            $themes[$key] = $container->getParameter('kernel.root_dir') . '/Resources/themes/' . $theme;
        }
        $themes[] = $container->getParameter('kernel.root_dir') . '/Resources/views';

        $container->setDefinition(
            'assetic.' . $engine . '_directory_resource.kernel',
            new DirectoryResourceDefinition('', $engine, $themes)
        );
    }
} 