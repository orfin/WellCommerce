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

namespace WellCommerce\Bundle\SearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractExtension;

/**
 * Class WellCommerceSearchExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class WellCommerceSearchExtension extends AbstractExtension
{
    protected function processExtensionConfiguration(array $configuration, ContainerBuilder $container)
    {
        parent::processExtensionConfiguration($configuration, $container);
        
        $adapters = $configuration['engine']['adapters'];
        $index    = $configuration['engine']['index'];
        $adapter  = $adapters[$container->getParameter('search_engine')] ?? current($adapters);
        
        $this->processTypes($index['types'], $container);
        $this->processAdapterConfiguration($adapter, $container);
    }
    
    private function processTypes(array $types, ContainerBuilder $container)
    {
        foreach ($types as $name => $options) {
            $definition = new Definition($options['class']);
            $definition->addArgument($name);
            $definition->addArgument($options['mapping']);
            $definition->setPublic(false);
            $definition->addTag('search.type', ['type' => $name]);
            $container->setDefinition('search.type.' . $name, $definition);
        }
    }
    
    private function processAdapterConfiguration(array $configuration, ContainerBuilder $container)
    {
        $definition = new Definition($configuration['class']);
        $definition->addArgument($configuration['options']);
        $definition->setPublic(false);
        $container->setDefinition('search.adapter', $definition);
    }
}
