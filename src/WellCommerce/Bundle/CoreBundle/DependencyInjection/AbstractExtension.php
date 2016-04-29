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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class AbstractExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        $reflected = new \ReflectionClass($this);
        $namespace = $reflected->getNamespaceName();
        
        $class = $namespace . '\\Configuration';
        if (class_exists($class)) {
            $r = new \ReflectionClass($class);
            $container->addResource(new FileResource($r->getFileName()));
            
            return new $class($this->getAlias());
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $reflection = new \ReflectionClass($this);
        $directory  = dirname($reflection->getFileName());
        
        $locator = new FileLocator($directory . '/../Resources/config');
        
        $xmlLoader = new Loader\XmlFileLoader($container, $locator);
        $xmlLoader->load('services.xml');
        
        $configuration = $this->getConfiguration($configs, $container);
        
        $this->processConfiguration($configuration, $configs);
    }
}
