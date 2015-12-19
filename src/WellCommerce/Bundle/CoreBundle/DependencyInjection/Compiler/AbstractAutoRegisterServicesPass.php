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

            if (null !== $repositoryClass) {
                $this->registerRepository($moduleName, $repositoryClass, $entityClass, $container);
            }

            if (null !== $factoryClass) {
                $this->registerFactory($moduleName, $factoryClass, $entityClass, $container);
            }

        }
    }

    protected function registerFactory($name, $factoryClass, $entityClass, ContainerBuilder $container)
    {
        $definition = new Definition($factoryClass);
        $definition->addArgument($entityClass);
        $container->setDefinition($name . '.factory', $definition);
    }

    protected function registerRepository($name, $repositoryClass, $entityClass, ContainerBuilder $container)
    {
        $definition = new Definition($repositoryClass);
        $definition->setFactoryService('doctrine.orm.entity_manager');
        $definition->setFactoryMethod('getRepository');
        $definition->addArgument($entityClass);

        $container->setDefinition($name . '.repository', $definition);
    }
}
