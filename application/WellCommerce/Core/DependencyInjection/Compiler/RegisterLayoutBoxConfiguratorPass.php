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
namespace WellCommerce\Core\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterLayoutBoxConfiguratorPass
 *
 * @package WellCommerce\Core\DependencyInjection\Compiler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterLayoutBoxConfiguratorPass implements CompilerPassInterface
{

    /**
     * Registers all layout box configurators
     *
     * @param ContainerBuilder $container
     *
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('layout_manager')) {
            return;
        }

        $definition = $container->getDefinition('layout_manager');

        foreach ($container->findTaggedServiceIds('layout_box.configurator') as $id => $attributes) {
            $configurator = $container->getDefinition($id);
            $class        = $configurator->getClass();
            $refClass     = new \ReflectionClass($class);
            $interface    = 'WellCommerce\\Core\\Layout\\Box\\LayoutBoxConfiguratorInterface';

            $configurator->setProperty('type', $attributes[0]['type']);
            $configurator->setProperty('controller', $attributes[0]['controller']);

            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, $interface));
            }
            $definition->addMethodCall('addLayoutBoxConfigurator', array(
                $attributes[0]['type'],
                new Reference($id)
            ));
        }
    }
}