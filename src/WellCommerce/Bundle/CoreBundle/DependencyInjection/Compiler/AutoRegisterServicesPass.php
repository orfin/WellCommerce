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
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\ClassFinder;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Definition\DataGridDefinitionFactory;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Definition\DataSetDefinitionFactory;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Definition\EntityFactoryDefinitionFactory;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Definition\FormBuilderDefinitionFactory;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Definition\ManagerDefinitionFactory;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Definition\RepositoryDefinitionFactory;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\ServiceIdGenerator;
use WellCommerce\Bundle\DistributionBundle\WellCommerceDistributionBundle;

/**
 * Class AutoRegisterServicesPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class AutoRegisterServicesPass implements CompilerPassInterface
{
    /**
     * @var BundleInterface
     */
    private $bundle;
    
    /**
     * @var ClassFinder
     */
    private $classFinder;
    
    /**
     * @var ServiceIdGenerator
     */
    private $serviceIdGenerator;
    
    /**
     * AutoRegisterServicesPass constructor.
     *
     * @param BundleInterface $bundle
     */
    public function __construct(BundleInterface $bundle)
    {
        $this->bundle             = $bundle;
        $this->classFinder        = new ClassFinder();
        $this->serviceIdGenerator = new ServiceIdGenerator();
    }
    
    public function process(ContainerBuilder $container)
    {
        $this->registerRepositories($container);
        $this->registerEntityFactory($container);
        $this->registerAdminDataSets($container);
        $this->registerFrontDataSets($container);
        $this->registerDataGrid($container);
        $this->registerAdminFormBuilders($container);
        $this->registerFrontFormBuilders($container);
        $this->registerManager($container);
    }
    
    private function registerRepositories(ContainerBuilder $container)
    {
        $definitionFactory = new RepositoryDefinitionFactory();
        $classes           = $this->classFinder->findEntityClasses($this->bundle);
        
        foreach ($classes as $baseName => $className) {
            $serviceId  = $this->serviceIdGenerator->getServiceId($baseName, 'repository');
            $definition = $definitionFactory->create($className);
            if (false === $container->has($serviceId)) {
                $container->setDefinition($serviceId, $definition);
            }
        }
    }
    
    private function registerAdminDataSets(ContainerBuilder $container)
    {
        $definitionFactory = new DataSetDefinitionFactory();
        $classes           = $this->classFinder->findDataSetClasses($this->bundle, 'Admin');
        
        foreach ($classes as $baseName => $className) {
            $repositoryServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'repository');
            if ($container->has($repositoryServiceId)) {
                $dataSetServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'dataset.admin');
                if (false === $container->has($dataSetServiceId)) {
                    $definition = $definitionFactory->create($repositoryServiceId, $className);
                    $container->setDefinition($dataSetServiceId, $definition);
                }
            }
        }
    }
    
    private function registerFrontDataSets(ContainerBuilder $container)
    {
        $definitionFactory = new DataSetDefinitionFactory();
        $classes           = $this->classFinder->findDataSetClasses($this->bundle, 'Front');
        
        foreach ($classes as $baseName => $className) {
            $repositoryServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'repository');
            if ($container->has($repositoryServiceId)) {
                $dataSetServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'dataset.front');
                if (false === $container->has($dataSetServiceId)) {
                    $definition = $definitionFactory->create($repositoryServiceId, $className);
                    $container->setDefinition($dataSetServiceId, $definition);
                }
            }
        }
    }
    
    private function registerAdminFormBuilders(ContainerBuilder $container)
    {
        $definitionFactory = new FormBuilderDefinitionFactory();
        $classes           = $this->classFinder->findFormBuilderClasses($this->bundle, 'Admin');
        
        foreach ($classes as $baseName => $className) {
            $formBuilderServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'form_builder.admin');
            if (false === $container->has($formBuilderServiceId)) {
                $definition = $definitionFactory->create($className);
                $container->setDefinition($formBuilderServiceId, $definition);
            }
        }
    }
    
    private function registerFrontFormBuilders(ContainerBuilder $container)
    {
        $definitionFactory = new FormBuilderDefinitionFactory();
        $classes           = $this->classFinder->findFormBuilderClasses($this->bundle, 'Front');
        
        foreach ($classes as $baseName => $className) {
            $formBuilderServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'form_builder.front');
            if (false === $container->has($formBuilderServiceId)) {
                $definition = $definitionFactory->create($className);
                $container->setDefinition($formBuilderServiceId, $definition);
            }
        }
    }
    
    private function registerDataGrid(ContainerBuilder $container)
    {
        $definitionFactory = new DataGridDefinitionFactory();
        $classes           = $this->classFinder->findDataGridClasses($this->bundle);
        foreach ($classes as $baseName => $className) {
            $dataSetServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'dataset.admin');
            if ($container->has($dataSetServiceId)) {
                $dataGridServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'datagrid');
                if (false === $container->has($dataGridServiceId)) {
                    $identifier = Container::underscore($baseName);
                    $definition = $definitionFactory->create($dataSetServiceId, $identifier, $className);
                    $container->setDefinition($dataGridServiceId, $definition);
                }
            }
        }
    }
    
    private function registerEntityFactory(ContainerBuilder $container)
    {
        $definitionFactory = new EntityFactoryDefinitionFactory();
        $classes           = $this->classFinder->findEntityFactoryClasses($this->bundle);
        foreach ($classes as $baseName => $className) {
            $entityFactoryServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'factory');
            if (false === $container->has($entityFactoryServiceId)) {
                $definition = $definitionFactory->create($className);
                $container->setDefinition($entityFactoryServiceId, $definition);
            }
        }
    }
    
    private function registerManager(ContainerBuilder $container)
    {
        $definitionFactory = new ManagerDefinitionFactory();
        $classes           = $this->classFinder->findManagerClasses($this->bundle);
        foreach ($classes as $baseName => $className) {
            $managerServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'manager');
            if (false === $container->has($managerServiceId)) {
                $factoryServiceId    = $this->serviceIdGenerator->getServiceId($baseName, 'factory');
                $repositoryServiceId = $this->serviceIdGenerator->getServiceId($baseName, 'repository');
                $factory             = $container->has($factoryServiceId) ? new Reference($factoryServiceId) : null;
                $repository          = $container->has($repositoryServiceId) ? new Reference($repositoryServiceId) : null;
                $definition          = $definitionFactory->create($className, $factory, $repository);
                $container->setDefinition($managerServiceId, $definition);
            }
        }
    }
}
