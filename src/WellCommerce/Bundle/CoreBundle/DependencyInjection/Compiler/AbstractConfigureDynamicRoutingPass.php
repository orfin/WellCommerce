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
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class AbstractConfigureDynamicRoutingPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractConfigureDynamicRoutingPass implements CompilerPassInterface
{
    /**
     * @return array
     */
    abstract protected function getExtensionConfiguration(ContainerBuilder $container);

    public function process(ContainerBuilder $container)
    {
        $routingDiscriminators = $container->getParameter('routing_discriminator_map');

        $parameters = $this->getExtensionConfiguration($container);
        $definition = new Definition($parameters['dynamic_routing']['generator'], [
            'defaults'     => $parameters['dynamic_routing']['defaults'],
            'requirements' => $parameters['dynamic_routing']['requirements'],
            'pattern'      => $parameters['dynamic_routing']['pattern'],
        ]);

        $definition->addTag('route.generator');
        $container->setDefinition($parameters['dynamic_routing']['name'] . '.route.generator', $definition);

        if (null !== $parameters['dynamic_routing']['entity']) {
            $routingDiscriminators[$parameters['dynamic_routing']['name']] = $parameters['dynamic_routing']['entity'];
            $container->setParameter('routing_discriminator_map', $routingDiscriminators);
        }
    }
}
