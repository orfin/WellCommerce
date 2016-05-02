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
use WellCommerce\Component\DataSet\Configurator\DataSetConfigurator;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class DataSetPass
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $tag       = 'dataset';
        $interface = DataSetInterface::class;

        foreach ($container->findTaggedServiceIds($tag) as $id => $attributes) {
            $definition = $container->getDefinition($id);
            $refClass   = new \ReflectionClass($definition->getClass());

            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(
                    sprintf('DataSet "%s" tagged with "%s" must implement interface "%s".', $id, $tag, $interface)
                );
            }

            $definition->addArgument(new Reference('dataset.manager'));
            $definition->addArgument(new Reference('event_dispatcher'));
            $definition->setConfigurator([new Reference('dataset.configurator'), 'configure']);
        }
    }
}
