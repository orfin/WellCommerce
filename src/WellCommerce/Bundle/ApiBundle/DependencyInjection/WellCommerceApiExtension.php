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

namespace WellCommerce\Bundle\ApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractExtension;

/**
 * Class WellCommerceApiExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceApiExtension extends AbstractExtension
{
    protected function processExtensionConfiguration(array $configuration, ContainerBuilder $container)
    {
        $requestHandlers      = $configuration['request_handler'];
        $serializationMapping = $configuration['serialization'];
        
        foreach ($requestHandlers as $rootName => $options) {
            $this->registerRequestHandler($rootName, $options, $container);
        }

        $container->setParameter('api.serialization_mapping_map', $serializationMapping);
    }

    private function registerRequestHandler(string $name, array $options, ContainerBuilder $container)
    {
        if (true === $options['enabled']) {
            $definition = new Definition($options['class']);
            $definition->addArgument($name);
            $definition->addArgument(new Reference($options['manager']));
            $definition->addArgument(new Reference('serializer'));
            $definition->addTag('api.request_handler');
            $container->setDefinition($name . '.api.request_handler', $definition);
        }
    }
}
