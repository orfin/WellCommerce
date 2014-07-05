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
namespace WellCommerce\Plugin\ShippingMethod\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterShippingCalculatorsPass
 *
 * @package WellCommerce\Plugin\ShippingMethod\DependencyInjection\Compiler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterShippingCalculatorsPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     *
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
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
            $interface = 'WellCommerce\\Plugin\\ShippingMethod\\Calculator\\ShippingMethodCalculatorInterface';
            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, $interface));
            }
            $definition->addMethodCall('add', array(
                new Reference($id)
            ));
        }
    }
}