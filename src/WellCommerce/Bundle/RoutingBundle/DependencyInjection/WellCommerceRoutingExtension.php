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

namespace WellCommerce\Bundle\RoutingBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractExtension;

/**
 * Class WellCommerceRoutingExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class WellCommerceRoutingExtension extends AbstractExtension
{
    /**
     * @var array
     */
    private $routingDiscriminatorMap;
    
    /**
     * @var array
     */
    private $routingGeneratorMap = [];
    
    protected function processExtensionConfiguration(array $configuration, ContainerBuilder $container)
    {
        parent::processExtensionConfiguration($configuration, $container);
        
        foreach ($configuration['dynamic_routing'] as $discriminatorName => $options) {
            $this->routingDiscriminatorMap[$discriminatorName] = $options['entity'];
            $this->routingGeneratorMap[$options['entity']]     = $options;
        }
        
        $router = $container->getDefinition('routing.chain_router');
        foreach ($configuration['routers'] as $id => $priority) {
            $router->addMethodCall('add', [new Reference($id), (int)$priority]);
        }
        
        $container->setAlias('router', 'routing.chain_router');
        $container->setParameter('routing_discriminator_map', $this->routingDiscriminatorMap);
        $container->setParameter('routing_generator_map', $this->routingGeneratorMap);
    }
}
