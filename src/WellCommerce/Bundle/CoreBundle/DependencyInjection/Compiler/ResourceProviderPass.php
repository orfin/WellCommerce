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

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ResourceProviderPass
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ResourceProviderPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('resource.provider.collection')) {
            return;
        }

        $collection = $container->getDefinition('resource.provider.collection');

        foreach ($container->findTaggedServiceIds('resource.provider') as $id => $attributes) {
            $collection->addMethodCall('add', [
                $attributes[0]['alias'],
                new Reference($id)
            ]);
        }
    }
}