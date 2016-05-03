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

/**
 * Class FirewallMapPass
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FirewallMapPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('security.helper')) {
            return;
        }

        $definition = $container->getDefinition('security.helper');
        $map        = $container->getDefinition('security.firewall.map');
        $maps       = $map->getArgument(1);

        $refs = [];
        foreach ($maps as $serviceName => $firewall) {
            $refs[substr($serviceName, 30)] = $firewall;
        }

        $definition->addArgument($refs);
    }
}
