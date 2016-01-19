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

            $this->registerRepository($moduleName, $repositoryClass, $entityClass, $container);
            $this->registerFactory($moduleName, $factoryClass, $entityClass, $container);
        }
    }

    /**
     * Automatic registration of factory service
     *
     * @param string           $name
     * @param string|null      $factoryClass
     * @param string           $entityClass
     * @param ContainerBuilder $container
     */
    protected function registerFactory($name, $factoryClass = null, $entityClass, ContainerBuilder $container)
    {
        if (null !== $factoryClass) {
            $definition = new Definition($factoryClass);
            $definition->addArgument($entityClass);
            $container->setDefinition($name . '.factory', $definition);
        }
    }

    /**
     * Automatic registration of factory service
     *
     * @param string           $name
     * @param string|null      $repositoryClass
     * @param string           $entityClass
     * @param ContainerBuilder $container
     */
    protected function registerRepository($name, $repositoryClass = null, $entityClass, ContainerBuilder $container)
    {
        if (null !== $repositoryClass) {
            $definition = new Definition($repositoryClass);
            $definition->setFactory([new Reference('doctrine.orm.entity_manager'), 'getRepository']);
            $definition->addArgument($entityClass);

            $container->setDefinition($name . '.repository', $definition);
        }
    }
}
