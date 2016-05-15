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
use WellCommerce\Bundle\SearchBundle\Manager\IndexManager;

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

        $indexes = $configuration['engine']['indexes'];
        foreach ($indexes as $indexName => $indexConfiguration) {
            $this->createIndexManager($indexName, $indexConfiguration, $container);
        }
    }
    
    private function createIndexManager(string $indexName, array $configuration, ContainerBuilder $container)
    {
        $documentFactory = $this->createDocumentFactory($indexName, $configuration, $container);
        $adapter         = $this->createAdapter($indexName, $configuration, $container);

        $indexManagerServiceName = $indexName . '.index.manager';
        $indexManager            = new Definition(IndexManager::class);
        $indexManager->addArgument($indexName);
        $indexManager->addArgument($documentFactory);
        $indexManager->addArgument(new Reference($adapter));
        $indexManager->addArgument(new Reference($configuration['repository']));
        $indexManager->addArgument(new Reference('search.result.storage'));
        $container->setDefinition($indexManagerServiceName, $indexManager);
    }
    
    private function createDocumentFactory(string $indexName, array $configuration, ContainerBuilder $container) : Reference
    {
        $documentFactoryServiceName = $indexName . '.document.factory';
        $documentFactory            = new Definition($configuration['document']['factory']);
        $documentFactory->addArgument($configuration['document']['context']);
        $documentFactory->setPublic(false);
        $container->setDefinition($documentFactoryServiceName, $documentFactory);

        return new Reference($documentFactoryServiceName);
    }
    
    private function createAdapter(string $indexName, array $configuration, ContainerBuilder $container) : Reference
    {
        $adapterServiceName = $indexName . '.search.adapter';
        $adapter            = new Definition($configuration['adapter']['class']);
        $adapter->addArgument($configuration['adapter']['options']);
        $container->setDefinition($adapterServiceName, $adapter);

        return new Reference($adapterServiceName);
    }
}
