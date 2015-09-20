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

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterCartTotalsVisitorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterCartTotalsVisitorPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('cart_totals.visitor.collection')) {
            return;
        }

        $definition = $container->getDefinition('cart_totals.visitor.collection');

        foreach ($container->findTaggedServiceIds('cart_totals.visitor') as $id => $attributes) {
            $class     = $container->getDefinition($id)->getClass();
            $refClass  = new \ReflectionClass($class);
            $interface = 'WellCommerce\\Bundle\\CartBundle\\Calculator\\CartTotalsVisitorInterface';
            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id,
                    $interface));
            }
            $definition->addMethodCall('add', [
                new Reference($id),
            ]);
        }
    }
}
