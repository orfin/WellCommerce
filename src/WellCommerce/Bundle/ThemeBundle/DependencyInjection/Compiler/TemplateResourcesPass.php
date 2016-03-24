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

namespace WellCommerce\Bundle\ThemeBundle\DependencyInjection\Compiler;

use Symfony\Bundle\AsseticBundle\DependencyInjection\DirectoryResourceDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\LogicException;

/**
 * Class TemplateResourcesPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * Created on base of the LiipThemeBundle <https://github.com/liip/LiipThemeBundle>
 *
 * Special thanks goes to its authors and contributors
 */
class TemplateResourcesPass implements CompilerPassInterface
{
    private $themes = ['wellcommerce'];

    /**
     * Processes the container
     *
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
    }

    protected function setBundleDirectoryResources(ContainerBuilder $container, $engine, $bundleDirName, $bundleName)
    {
        if (!$container->hasDefinition('assetic.' . $engine . '_directory_resource.' . $bundleName)) {
            throw new LogicException('The AppBundle must be registered after the AsseticBundle in the application Kernel.');
        }
        $definition = 'assetic.' . $engine . '_directory_resource.' . $bundleName;
        $resources  = $container->getDefinition($definition)->getArgument(0);

        foreach ($this->themes as $theme) {
            $resources[] = new DirectoryResourceDefinition(
                $bundleName,
                $engine,
                [
                    $container->getParameter('kernel.root_dir') . '/Resources/' . $bundleName . '/themes/' . $theme,
                    $container->getParameter('kernel.root_dir') . '/web/themes/' . $theme,
                    $bundleDirName . '/Resources/themes/' . $theme,
                ]
            );
        }

        $container->getDefinition('assetic.' . $engine . '_directory_resource.' . $bundleName)->replaceArgument(0, $resources);
    }
}
