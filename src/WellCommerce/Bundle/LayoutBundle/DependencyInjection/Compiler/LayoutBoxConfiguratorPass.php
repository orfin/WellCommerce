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
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class LayoutBoxConfiguratorPass
 *
 * @package WellCommerce\Bundle\LayoutBundle\DependencyInjection\Compiler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxConfiguratorPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('layout_box.configurator.collection')) {
            return;
        }

        $collection = $container->getDefinition('layout_box.configurator.collection');

        foreach ($container->findTaggedServiceIds('layout_box.configurator') as $id => $attributes) {
            $collection->addMethodCall('add', [
                $attributes[0]['type'],
                new Reference($id)
            ]);
        }
    }
}