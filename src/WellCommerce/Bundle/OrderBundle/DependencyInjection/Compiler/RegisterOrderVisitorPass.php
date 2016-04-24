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

namespace WellCommerce\Bundle\OrderBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorInterface;

/**
 * Class RegisterOrderVisitorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterOrderVisitorPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $tag         = 'order.visitor';
        $interface   = OrderVisitorInterface::class;
        $definition  = $container->getDefinition('order.visitor.collection');
        $visitors    = [];
        $hierarchies = $container->getParameter('order_visitor_hierarchy');

        foreach ($container->findTaggedServiceIds($tag) as $id => $attributes) {
            $hierarchy      = $hierarchies[$attributes[0]['alias']] ?? 0;
            $itemDefinition = $container->getDefinition($id);
            $refClass       = new \ReflectionClass($itemDefinition->getClass());
            
            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(
                    sprintf('Order visitor "%s" must implement interface "%s".', $id, $interface)
                );
            }

            $visitors[$hierarchy][] = new Reference($id);
        }

        ksort($visitors);
        $visitors = call_user_func_array('array_merge', $visitors);

        foreach ($visitors as $visitor) {
            $definition->addMethodCall('add', [
                $visitor
            ]);
        }
    }
}
