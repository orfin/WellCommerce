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
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Component\Form\Resolver\ResolverInterface;

/**
 * Class FormResolverPass
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormResolverPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('form.resolver.factory')) {
            $this->processResolvers($container);
        }
    }

    private function processResolvers(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('form.resolver.factory');
        $interface  = ResolverInterface::class;

        foreach ($container->findTaggedServiceIds('form.resolver') as $id => $attributes) {
            $resolverDefinition = $container->getDefinition($id);
            $refClass           = new \ReflectionClass($resolverDefinition->getClass());

            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(
                    sprintf('Form resolver "%s" must implement interface "%s".', $id, $interface)
                );
            }

            $definition->addMethodCall('addResolver', [
                $attributes[0]['type'],
                new Reference($id)
            ]);

            $this->processResolverItems($resolverDefinition, $refClass, $container);
        }
    }

    protected function processResolverItems(Definition $definition, \ReflectionClass $refClass, ContainerBuilder $container)
    {
        $tag       = $refClass->getConstant('SERVICE_TAG_NAME');
        $interface = $refClass->getConstant('INTERFACE_CLASS');

        foreach ($container->findTaggedServiceIds($tag) as $id => $attributes) {
            $itemDefinition = $container->getDefinition($id);
            $refClass       = new \ReflectionClass($itemDefinition->getClass());

            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(
                    sprintf('Element "%s" tagged with "%s" must implement interface "%s".', $id, $tag, $interface)
                );
            }

            $definition->addMethodCall('add', [
                $attributes[0]['alias'],
                $id
            ]);
        }
    }
}
