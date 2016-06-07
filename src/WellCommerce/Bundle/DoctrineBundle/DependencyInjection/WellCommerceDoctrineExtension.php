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

namespace WellCommerce\Bundle\DoctrineBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractExtension;

/**
 * Class WellCommerceDoctrineExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceDoctrineExtension extends AbstractExtension
{
    private $doctrineMappingMap;

    protected function processExtensionConfiguration(array $configuration, ContainerBuilder $container)
    {
        foreach ($configuration['configuration'] as $rootName => $ormConfiguration) {
            $this->processOrmConfiguration($rootName, $ormConfiguration, $container);
        }

        $container->setParameter('doctrine_orm_mapping_map', $this->doctrineMappingMap);
    }
    
    private function processOrmConfiguration(string $name, array $ormConfiguration, ContainerBuilder $container)
    {
        $this->doctrineMappingMap[$ormConfiguration['entity']] = $ormConfiguration['mapping'];

        $factoryService    = $this->registerFactory($name, $ormConfiguration, $container);
        $repositoryService = $this->registerRepository($name, $ormConfiguration, $container);
        
        $this->registerManager($name, $factoryService, $repositoryService, $ormConfiguration, $container);
    }
    
    /**
     * Registers the factory service for entity
     *
     * @param string           $name
     * @param array            $configuration
     * @param ContainerBuilder $container
     *
     * @return null|Reference
     */
    private function registerFactory(string $name, array $configuration, ContainerBuilder $container)
    {
        $factoryService = null;
        
        if (false !== $configuration['factory']) {
            $definition = new Definition($configuration['factory']);
            $definition->addArgument($configuration['entity']);
            $definition->addMethodCall('setContainer', [new Reference('service_container')]);
            $factoryServiceName = $this->getAutoServiceName($name, 'factory');
            
            $container->setDefinition($factoryServiceName, $definition);
            $factoryService = new Reference($factoryServiceName);
        }
        
        return $factoryService;
    }
    
    /**
     * Registers the repository service for entity
     *
     * @param string           $name
     * @param array            $configuration
     * @param ContainerBuilder $container
     *
     * @return null|Reference
     */
    private function registerRepository(string $name, array $configuration, ContainerBuilder $container)
    {
        $repositoryService = null;
        
        if (false !== $configuration['repository']) {
            $definition = new Definition($configuration['repository']);
            $definition->setFactory([new Reference('doctrine.orm.entity_manager'), 'getRepository']);
            $definition->addArgument($configuration['entity']);
            $repositoryServiceName = $this->getAutoServiceName($name, 'repository');
            
            $container->setDefinition($repositoryServiceName, $definition);
            $repositoryService = new Reference($repositoryServiceName);
        }
        
        return $repositoryService;
    }
    
    /**
     * Registers the manager service for entity and factory
     *
     * @param string           $name
     * @param                  $factoryService
     * @param                  $repositoryService
     * @param array            $configuration
     * @param ContainerBuilder $container
     */
    private function registerManager(string $name, $factoryService, $repositoryService, array $configuration, ContainerBuilder $container)
    {
        if (false !== $configuration['manager']) {
            $managerServiceName = $this->getAutoServiceName($name, 'manager');
            $definition         = new Definition($configuration['manager']);
            $definition->addArgument($factoryService);
            $definition->addArgument($repositoryService);
            $definition->addArgument(new Reference('doctrine.helper'));
            $definition->addArgument(new Reference('event_dispatcher'));
            $container->setDefinition($managerServiceName, $definition);
        }
    }
}
