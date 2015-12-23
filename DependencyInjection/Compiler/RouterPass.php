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
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\AbstractCollectionPass;
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
        $container->setAlias('router', 'routing.router');

        print_r($container->getParameter(WellCommerceRoutingExtension::EXTENSION_NAME));
        die();
    }
}
