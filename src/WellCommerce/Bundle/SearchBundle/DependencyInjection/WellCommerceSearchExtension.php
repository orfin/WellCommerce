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
        $indexes  = $configuration['engine']['indexes'];

        foreach ($adapters as $adapterName => $adapterConfiguration) {
            $this->createSearchAdapter($adapterName, $adapterConfiguration, $container);
        }

        foreach ($indexes as $indexName => $indexConfiguration) {
            $this->createIndexManager($indexName, $indexConfiguration, $container);
        }
    }
    
    private function createSearchAdapter(string $adapterName, array $adapterConfiguration, ContainerBuilder $container)
    {
        $adapterName = $this->getSearchAdapterServiceName($adapterName);
        $adapter     = new Definition($adapterConfiguration['class']);
        $adapter->addArgument($adapterConfiguration['options']);
        $adapter->setPublic(false);
        $container->setDefinition($adapterName, $adapter);
    }
    
    private function createIndexManager(string $indexName, array $indexConfiguration, ContainerBuilder $container)
    {
        print_r($indexConfiguration);
        die();
    }
    
    private function getSearchAdapterServiceName(string $adapterName) : string
    {
        return sprintf('search.adapter.%s', $adapterName);
    }
}
