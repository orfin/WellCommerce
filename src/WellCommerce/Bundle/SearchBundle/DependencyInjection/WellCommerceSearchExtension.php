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
use WellCommerce\Bundle\SearchBundle\Manager\SearchManager;

/**
 * Class WellCommerceSearchExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceSearchExtension extends AbstractExtension
{
    protected function processExtensionConfiguration(array $configuration, ContainerBuilder $container)
    {
        parent::processExtensionConfiguration($configuration, $container);
        
        $indexes = $configuration['indexes'];
        
        foreach ($indexes as $indexName => $parameters) {
            $this->createSearchManager($indexName, $parameters, $container);
        }
    }
    
    protected function createSearchManager(string $indexName, array $parameters, ContainerBuilder $container)
    {
        $serviceName = 'search.manager.' . $indexName;
        $definition  = new Definition(SearchManager::class);
        $definition->addArgument(new Reference($parameters['indexer']));
        $definition->addArgument(new Reference($parameters['provider']));
        $container->setDefinition($serviceName, $definition);
    }
}
