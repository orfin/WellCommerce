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
namespace WellCommerce\Plugin\PaymentMethod\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterPaymentMethodPass
 *
 * @package WellCommerce\Plugin\PaymentMethod\DependencyInjection\Compiler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterPaymentMethodPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     *
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('payment_method.processor.collection')) {
            return;
        }

        $definition = $container->getDefinition('payment_method.processor.collection');

        foreach ($container->findTaggedServiceIds('payment_method.processor') as $id => $attributes) {
            $class     = $container->getDefinition($id)->getClass();
            $refClass  = new \ReflectionClass($class);
            $interface = 'WellCommerce\\Plugin\\PaymentMethod\\Processor\\PaymentMethodProcessorInterface';
            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, $interface));
            }
            $definition->addMethodCall('add', array(
                new Reference($id)
            ));
        }

        if (!$container->hasDefinition('payment_method.processor.collection')) {
            return;
        }

        $definition = $container->getDefinition('payment_method.configurator.collection');

        foreach ($container->findTaggedServiceIds('payment_method.configurator') as $id => $attributes) {
            $class     = $container->getDefinition($id)->getClass();
            $refClass  = new \ReflectionClass($class);
            $interface = 'WellCommerce\\Plugin\\PaymentMethod\\Configurator\\PaymentMethodConfiguratorInterface';
            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, $interface));
            }
            $definition->addMethodCall('add', array(
                new Reference($id)
            ));
        }
    }
}