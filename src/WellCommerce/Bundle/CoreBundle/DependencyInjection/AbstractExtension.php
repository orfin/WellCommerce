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

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection;

use ReflectionClass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class AbstractExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractExtension extends Extension
{
    /**
     * @var array
     */
    private $doctrineMappingsMap = [];
    
    /**
     * @var array
     */
    private $routingDiscriminatorsMap = [];
    
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        $reflected = new ReflectionClass($this);
        $namespace = $reflected->getNamespaceName();
        $class     = $namespace . '\\Configuration';
        $directory = dirname($reflected->getFileName());
        $filename  = $directory . '/Configuration.php';
        
        if (!is_file($filename)) {
            $class = Configuration::class;
        }
        
        $r = new \ReflectionClass($class);
        $container->addResource(new FileResource($r->getFileName()));
        
        return new $class($this->getAlias());
    }
    
    public function load(array $configs, ContainerBuilder $container)
    {
        $reflection = new ReflectionClass($this);
        $directory  = dirname($reflection->getFileName());
        $locator    = new FileLocator($directory . '/../Resources/config');
        
        $xmlLoader = new Loader\XmlFileLoader($container, $locator);
        $xmlLoader->load('services.xml');
        
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);
        
        $this->processExtensionConfiguration($config, $container);
        
        $this->setDoctrineMappings($container);
        $this->setRoutingDiscriminators($container);
    }
    
    /**
     * Processes the configuration values and automatically registers all needed extension's services
     *
     * @param array            $configuration
     * @param ContainerBuilder $container
     */
    protected function processExtensionConfiguration(array $configuration, ContainerBuilder $container)
    {
        foreach ($configuration['configuration'] as $name => $moduleConfiguration) {
            $this->processOrmConfiguration($name, $moduleConfiguration['orm'], $container);
            if (isset($moduleConfiguration['api'])) {
                $this->registerApiRequestHandler($name, $moduleConfiguration['api'], $container);
            }
            if (isset($moduleConfiguration['dynamic_routing'])) {
                $this->processDynamicRoutingConfiguration($name, $moduleConfiguration['dynamic_routing'], $container);
            }
        }
    }
    
    /**
     * Sets the doctrine mapping map for extension
     *
     * @param ContainerBuilder $container
     */
    private function setDoctrineMappings(ContainerBuilder $container)
    {
        if (!empty($this->doctrineMappingsMap)) {
            $container->setParameter($this->getAlias() . '.doctrine_orm_mapping.map', $this->doctrineMappingsMap);
        }
    }
    
    /**
     * Sets the routing discriminators map for extension
     *
     * @param ContainerBuilder $container
     */
    private function setRoutingDiscriminators(ContainerBuilder $container)
    {
        if (!empty($this->routingDiscriminatorsMap)) {
            $container->setParameter($this->getAlias() . '.routing_discriminator.map', $this->routingDiscriminatorsMap);
        }
    }
    
    /**
     * Registers the API handler service
     *
     * @param string           $name
     * @param array            $configuration
     * @param ContainerBuilder $container
     */
    private function registerApiRequestHandler(string $name, array $configuration, ContainerBuilder $container)
    {
        $requestHandlerClass = $configuration['request_handler'];
        $datasetService      = $configuration['dataset'];
        $managerService      = $configuration['manager'];
        
        if (false === $container->hasDefinition($datasetService) || false === $container->hasDefinition($managerService)) {
            return;
        }
        
        $definition = new Definition($requestHandlerClass);
        $definition->addArgument($name);
        $definition->addArgument(new Reference($datasetService));
        $definition->addArgument(new Reference($managerService));
        $definition->addArgument(new Reference('serializer'));
        $definition->addTag('api.request_handler');
        $container->setDefinition($name . '.api.request_handler', $definition);
    }
    
    /**
     * Registers the route generator service and adds an entity to discriminators map (processed by compiler pass)
     *
     * @param string           $name
     * @param array            $configuration
     * @param ContainerBuilder $container
     *
     * @see \WellCommerce\Bundle\RoutingBundle\DependencyInjection\Compiler\RegisterRoutingDiscriminatorsPass
     */
    private function processDynamicRoutingConfiguration(string $name, array $configuration, ContainerBuilder $container)
    {
        if (null !== $configuration['entity']) {
            $this->routingDiscriminatorsMap[$name] = $configuration['entity'];
        }
        
        $definition = new Definition($configuration['generator'], [
            'defaults'     => $configuration['defaults'],
            'requirements' => $configuration['requirements'],
            'pattern'      => $configuration['pattern'],
        ]);
        
        $definition->addTag('route.generator');
        $container->setDefinition($name . '.route.generator', $definition);
    }
    
    /**
     * Registers factory, repository and manager service. Adds entity and mapping to mappings map (processed in compiler pass)
     *
     * @param string           $name
     * @param array            $ormConfiguration
     * @param ContainerBuilder $container
     *
     * @see \WellCommerce\Bundle\DoctrineBundle\DependencyInjection\Compiler\RegisterDoctrineMappingPass
     */
    private function processOrmConfiguration(string $name, array $ormConfiguration, ContainerBuilder $container)
    {
        $entityClass                             = $ormConfiguration['entity'];
        $mappingFile                             = $ormConfiguration['mapping'];
        $this->doctrineMappingsMap[$entityClass] = $mappingFile;
        
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
        
        if (null !== $configuration['factory']) {
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
        
        if (null !== $configuration['repository']) {
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
        $managerServiceName = $this->getAutoServiceName($name, 'manager');
        $definition         = new Definition($configuration['manager']);
        $definition->addArgument($factoryService);
        $definition->addArgument($repositoryService);
        $definition->addArgument(new Reference('doctrine.helper'));
        $container->setDefinition($managerServiceName, $definition);
    }
    
    /**
     * Returns a friendly service name for given type
     *
     * @param string $name
     * @param string $type
     *
     * @return string
     */
    private function getAutoServiceName(string $name, string $type) : string
    {
        return sprintf('%s.%s', $name, $type);
    }
}
