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

namespace WellCommerce\Bundle\ShippingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodOptionsProviderInterface;

/**
 * Class RegisterShippingMethodOptionsProviderPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterShippingMethodOptionsProviderPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $tag        = 'shipping_method.options_provider';
        $interface  = ShippingMethodOptionsProviderInterface::class;
        $definition = $container->getDefinition('shipping_method.options_provider.collection');
        
        foreach ($container->findTaggedServiceIds($tag) as $id => $attributes) {
            $itemDefinition = $container->getDefinition($id);
            $refClass       = new \ReflectionClass($itemDefinition->getClass());
            
            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(
                    sprintf('Shipping options provider "%s" must implement interface "%s".', $id, $interface)
                );
            }
            
            $definition->addMethodCall('set', [
                $attributes[0]['alias'],
                new Reference($id)
            ]);
        }
    }
}
