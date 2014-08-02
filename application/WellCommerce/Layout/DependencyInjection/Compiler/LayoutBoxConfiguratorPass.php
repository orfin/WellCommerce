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
namespace WellCommerce\Layout\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class LayoutBoxConfiguratorPass
 *
 * Registers all layout box configurators in container
 *
 * @package WellCommerce\Layout\DependencyInjection\Compiler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxConfiguratorPass implements CompilerPassInterface
{
    const LAYOUT_BOX_CONFIGURATOR_INTERFACE = 'WellCommerce\\Core\\Layout\\Box\\LayoutBoxConfiguratorInterface';

    /**
     * {@inheritdoc}
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

            $service = $container->getDefinition($attributes[0]['controller'])->getClass();

            $configurator->setProperty('type', $attributes[0]['type']);
            $configurator->setProperty('controller', $attributes[0]['controller']);
            $configurator->setProperty('class', $service);

            if (!$refClass->implementsInterface(self::LAYOUT_BOX_CONFIGURATOR_INTERFACE)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, self::LAYOUT_BOX_CONFIGURATOR_INTERFACE));
            }
            $definition->addMethodCall('addLayoutBoxConfigurator', [
                $attributes[0]['type'],
                new Reference($id)
            ]);
        }
    }
}