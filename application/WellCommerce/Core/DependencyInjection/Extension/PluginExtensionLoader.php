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
namespace WellCommerce\Core\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper;
use Symfony\Component\Routing\Generator\Dumper\PhpGeneratorDumper;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Finder\Finder;

/**
 * Class PluginExtensionLoader
 *
 * Scans all application directories for extensions and registers them in container
 *
 * @package WellCommerce\Core\DependencyInjection\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PluginExtensionLoader
{
    const ROUTING_GENERATOR_CLASS = 'WellCommerceUrlGenerator';
    const ROUTING_MATCHER_CLASS   = 'WellCommerceUrlMatcher';

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected $containerBuilder;

    /**
     * @var \Symfony\Component\Routing\RouteCollection
     */
    protected $routeCollection;

    public function __construct(ContainerBuilder $containerBuilder, RouteCollection $routeCollection)
    {
        $this->containerBuilder = $containerBuilder;
        $this->routeCollection  = $routeCollection;
    }

    /**
     * Registers all available extensions using recursive directory search
     */
    public function registerExtensions()
    {
        $finder = new Finder();
        $files  = $finder->files()->in(ROOTPATH . 'application')->name('*Extension.php');

        foreach ($files as $file) {
            $namespace = $file->getRelativePath();
            $class     = $namespace . '\\' . $file->getBasename('.php');
            $refClass  = new \ReflectionClass($class);
            $interface = 'Symfony\\Component\\DependencyInjection\\Extension\\ExtensionInterface';
            if ($refClass->isInstantiable() && $refClass->implementsInterface($interface)) {
                $extension = new $class();
                $this->containerBuilder->registerExtension($extension);
                $this->containerBuilder->loadFromExtension($extension->getAlias());
                $extension->registerRoutes($this->routeCollection, $this->containerBuilder);
            }

        }
    }

    /**
     * Dumps route collection
     */
    public function dumpRouting()
    {
        $filesystem = new Filesystem();
        $dumper     = new PhpGeneratorDumper($this->routeCollection);
        $filesystem->dumpFile(ROOTPATH . 'var' . DS . sprintf('%s.php', self::ROUTING_GENERATOR_CLASS), $dumper->dump(Array(
            'class' => self::ROUTING_GENERATOR_CLASS
        )));

        $dumper = new PhpMatcherDumper($this->routeCollection);
        $filesystem->dumpFile(ROOTPATH . 'var' . DS . sprintf('%s.php', self::ROUTING_MATCHER_CLASS), $dumper->dump(Array(
            'class' => self::ROUTING_MATCHER_CLASS
        )));
    }
}