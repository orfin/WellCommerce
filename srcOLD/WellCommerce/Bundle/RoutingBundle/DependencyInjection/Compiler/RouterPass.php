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

namespace WellCommerce\Bundle\RoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\RoutingBundle\DependencyInjection\WellCommerceRoutingExtension;

/**
 * Class RouteGeneratorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouterPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter(WellCommerceRoutingExtension::EXTENSION_NAME);
        $router = $container->getDefinition('routing.chain_router');
        foreach ($config['routers'] as $id => $priority) {
            $router->addMethodCall('add', [new Reference($id), (int)$priority]);
        }

        $container->setAlias('router', 'routing.chain_router');
    }
}
