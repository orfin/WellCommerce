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

namespace WellCommerce\Bundle\CartBundle\DependencyInjection\Compiler;

use Doctrine\Common\Util\Debug;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorInterface;

/**
 * Class RegisterCartVisitorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterCartVisitorPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $tag         = 'cart.visitor';
        $interface   = CartVisitorInterface::class;
        $definition  = $container->getDefinition('cart.visitor.collection');
        $visitors    = [];
        $hierarchies = $container->getParameter('cart_visitor_hierarchy');

        foreach ($container->findTaggedServiceIds($tag) as $id => $attributes) {
            $hierarchy      = $hierarchies[$attributes[0]['alias']] ?? 0;
            $itemDefinition = $container->getDefinition($id);
            $refClass       = new \ReflectionClass($itemDefinition->getClass());
            
            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(
                    sprintf('Cart visitor "%s" must implement interface "%s".', $id, $interface)
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
