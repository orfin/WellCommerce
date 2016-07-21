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
    public function load(array $configs, ContainerBuilder $container)
    {
        $reflection = new ReflectionClass($this);
        $directory  = dirname($reflection->getFileName());
        $locator    = new FileLocator($directory . '/../Resources/config');
        $xmlLoader  = new Loader\YamlFileLoader($container, $locator);
        if (!empty($locator->locate('services.yml'))) {
            $xmlLoader->load('services.yml');
        }
        
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);
        
        $this->processExtensionConfiguration($config, $container);
    }
    
    /**
     * Processes the configuration values and automatically registers all needed extension's services
     *
     * @param array            $configuration
     * @param ContainerBuilder $container
     */
    protected function processExtensionConfiguration(array $configuration, ContainerBuilder $container)
    {
    }
}
