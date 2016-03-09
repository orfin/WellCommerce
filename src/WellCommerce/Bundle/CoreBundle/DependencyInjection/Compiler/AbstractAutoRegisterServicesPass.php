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

        foreach ($parameters['services'] as $moduleName => $config) {
            $repositoryClass = $config['auto_services']['repository'];
            $factoryClass    = $config['auto_services']['factory'];
            $entityClass     = $config['orm_configuration']['entity'];
            $apiExposed      = $config['api_configuration']['exposed'];

            if (null !== $repositoryClass) {
                $this->registerRepository($moduleName, $repositoryClass, $entityClass, $container);
            }

            if (null !== $factoryClass) {
                $this->registerFactory($moduleName, $factoryClass, $entityClass, $container);
            }

            if (true === $apiExposed) {
                $this->registerApiRequestHandler($moduleName, $config['api_configuration'], $container);
            }
        }
    }

    /**
     * Registers the API request handler for given resource type
     *
     * @param string           $resourceType
     * @param array            $configuration
     * @param ContainerBuilder $container
     */
    protected function registerApiRequestHandler($resourceType, array $configuration, ContainerBuilder $container)
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
     * @param string           $name
     * @param string           $factoryClass
     * @param string           $entityClass
     * @param ContainerBuilder $container
     */
    protected function registerFactory($name, $factoryClass, $entityClass, ContainerBuilder $container)
    {
        $serviceName = $name . '.factory';
        $definition  = new Definition($factoryClass);
        $definition->addArgument($entityClass);
        $container->setDefinition($serviceName, $definition);
    }

    /**
     * Registers the repository service
     *
     * @param string           $name
     * @param string           $repositoryClass
     * @param string           $entityClass
     * @param ContainerBuilder $container
     */
    protected function registerRepository($name, $repositoryClass, $entityClass, ContainerBuilder $container)
    {
        $serviceName = $name . '.repository';
        $definition  = new Definition($repositoryClass);
        $definition->setFactory([new Reference('doctrine.orm.entity_manager'), 'getRepository']);
        $definition->addArgument($entityClass);

        $container->setDefinition($serviceName, $definition);
    }
}
