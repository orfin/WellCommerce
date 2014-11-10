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

namespace WellCommerce\Bundle\RoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RouteGeneratorPass
 *
 * @package WellCommerce\Bundle\RoutingBundle\DependencyInjection\Compiler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteGeneratorPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('route.generator.collection')) {
            return;
        }

        $collection = $container->getDefinition('route.generator.collection');

        foreach ($container->findTaggedServiceIds('route.generator') as $id => $attributes) {
            $collection->addMethodCall('add', [
                new Reference($id)
            ]);
        }
    }
}