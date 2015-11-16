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

namespace WellCommerce\Bundle\SalesBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterShippingMethodCalculatorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterShippingMethodCalculatorPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('shipping_method.calculator.collection')) {
            return;
        }

        $definition = $container->getDefinition('shipping_method.calculator.collection');

        foreach ($container->findTaggedServiceIds('shipping_method.calculator') as $id => $attributes) {
            $class     = $container->getDefinition($id)->getClass();
            $refClass  = new \ReflectionClass($class);
            $interface = 'WellCommerce\\Bundle\\SalesBundle\\Calculator\\ShippingMethodCalculatorInterface';
            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id,
                    $interface));
            }
            $definition->addMethodCall('add', [
                new Reference($id),
            ]);
        }
    }
}
