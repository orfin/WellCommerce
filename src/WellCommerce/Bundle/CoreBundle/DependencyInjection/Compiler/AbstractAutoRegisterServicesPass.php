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
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AbstractAutoRegisterServicesPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAutoRegisterServicesPass implements CompilerPassInterface
{
    /**
     * @return array
     */
    abstract protected function getExtensionConfiguration(ContainerBuilder $container);
    
    public function process(ContainerBuilder $container)
    {
        $parameters = $this->getExtensionConfiguration($container);
        
        foreach ($parameters['services'] as $moduleName => $moduleConfiguration) {
            $repositoryClass = $config['auto_services']['repository'];
            $factoryClass    = $config['auto_services']['factory'];
            $entityClass     = $config['orm_configuration']['entity'];
            $apiExposed      = $config['api_configuration']['exposed'];
            
            if (null !== $repositoryClass) {
                $repository = $this->registerRepository($moduleName, $repositoryClass, $entityClass, $container);
            }
            
            if (null !== $factoryClass) {
                $factory = $this->registerFactory($moduleName, $factoryClass, $entityClass, $container);
            }
            
            if (true === $apiExposed) {
                $this->registerApiRequestHandler($moduleName, $config['api_configuration'], $container);
            }
        }
    }
    
    private function autoRegisterRepository(string $name, array $configuration, ContainerBuilder $container)
    {
        $entityClass     = $configuration['entity'];
        $repositoryClass = $configuration['repository'];

        if (null !== $repositoryClass) {
            $serviceName = $name . '.repository';
            $definition  = new Definition($repositoryClass);
            $definition->setFactory([new Reference('doctrine.orm.entity_manager'), 'getRepository']);
            $definition->addArgument($entityClass);

            $container->setDefinition($serviceName, $definition);
        }
    }
    
    /**
     * Registers the API request handler for given resource type
     *
     * @param string           $resourceType
     * @param array            $configuration
     * @param ContainerBuilder $container
     */
    protected function registerApiRequestHandler(string $resourceType, array $configuration, ContainerBuilder $container)
    {
        $datasetService = $configuration['dataset'];
        $managerService = $configuration['manager'];
        if (false === $container->hasDefinition($datasetService) || false === $container->hasDefinition($managerService)) {
            return;
        }
        
        $definition = new Definition($container->getParameter('api.request_handler.class'));
        $definition->addArgument($resourceType);
        $definition->addArgument(new Reference($datasetService));
        $definition->addArgument(new Reference($managerService));
        $definition->addArgument(new Reference('serializer'));
        $definition->addTag('api.request_handler');
        
        $container->setDefinition($resourceType . '.api.request_handler', $definition);
    }
    
    /**
     * Registers the factory service
     *
     * @param                  $name
     * @param                  $factoryClass
     * @param                  $entityClass
     * @param ContainerBuilder $container
     *
     * @return string
     */
    protected function registerFactory(string $name, string $factoryClass, string $entityClass, ContainerBuilder $container) : string
    {
        $serviceName = $name . '.factory';
        $definition  = new Definition($factoryClass);
        $definition->addArgument($entityClass);
        $definition->addMethodCall('setContainer', [new Reference('service_container')]);
        $container->setDefinition($serviceName, $definition);
        
        return $serviceName;
    }
    
    /**
     * Registers the repository service
     *
     * @param string           $name
     * @param string           $repositoryClass
     * @param string           $entityClass
     * @param ContainerBuilder $container
     */
    protected function registerRepository(string $name, string $repositoryClass, string $entityClass, ContainerBuilder $container)
    {
        $serviceName = $name . '.repository';
        $definition  = new Definition($repositoryClass);
        $definition->setFactory([new Reference('doctrine.orm.entity_manager'), 'getRepository']);
        $definition->addArgument($entityClass);
        
        $container->setDefinition($serviceName, $definition);
    }
}
