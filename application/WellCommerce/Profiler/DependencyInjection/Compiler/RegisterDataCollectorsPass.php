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
namespace WellCommerce\Profiler\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterDataCollectorsPass
 *
 * @package WellCommerce\Profiler\DependencyInjection\Compiler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterDataCollectorsPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     *
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('profiler')) {
            return;
        }

        $definition = $container->getDefinition('profiler');
        $collectors = new \SplPriorityQueue();
        $order      = PHP_INT_MAX;

        foreach ($container->findTaggedServiceIds('data_collector') as $id => $attributes) {
            $priority = isset($attributes[0]['priority']) ? $attributes[0]['priority'] : 0;
            $template = null;

            if (isset($attributes[0]['template'])) {
                if (!isset($attributes[0]['id'])) {
                    throw new \InvalidArgumentException(sprintf('Data collector service "%s" must have an id attribute in order to specify a template', $id));
                }
            }

            $collectors->insert($id, array($priority, --$order));

            foreach ($collectors as $collector) {
                $definition->addMethodCall('add', array(new Reference($collector)));
            }
        }
    }
}