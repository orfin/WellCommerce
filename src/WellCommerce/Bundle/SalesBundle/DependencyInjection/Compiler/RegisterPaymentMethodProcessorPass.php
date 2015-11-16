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
 * Class RegisterPaymentMethodProcessorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterPaymentMethodProcessorPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
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
            $interface = 'WellCommerce\\Bundle\\SalesBundle\\Processor\\PaymentMethodProcessorInterface';
            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id,
                        $interface));
            }
            $definition->addMethodCall('add', array(
                new Reference($id),
            ));
        }
    }
}
