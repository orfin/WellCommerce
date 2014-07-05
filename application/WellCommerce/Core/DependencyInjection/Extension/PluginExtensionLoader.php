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

    /**
     * @var array Plugin classes
     */
    private $classes = [];

    /**
     * Constructor
     *
     * @param ContainerBuilder $containerBuilder
     * @param RouteCollection  $routeCollection
     */
    public function __construct(ContainerBuilder $containerBuilder, RouteCollection $routeCollection)
    {
        $this->containerBuilder = $containerBuilder;
        $this->routeCollection  = $routeCollection;
        $this->classes          = $this->getPluginClasses();
    }

    public function register()
    {
        $this->registerExtensions();
        $this->registerRoutes();
        $this->postProcess();
    }

    /**
     * Returns all plugin fetched during recursive filesystem scan
     *
     * @return array
     */
    private function getPluginClasses()
    {
        $finder  = new Finder();
        $files   = $finder->files()->in(ROOTPATH . 'application')->name('*Extension.php');
        $classes = [];
        foreach ($files as $file) {
            $namespace = $file->getRelativePath();
            $class     = $namespace . '\\' . $file->getBasename('.php');
            $refClass  = new \ReflectionClass($class);
            $interface = 'Symfony\\Component\\DependencyInjection\\Extension\\ExtensionInterface';
            if ($refClass->isInstantiable() && $refClass->implementsInterface($interface)) {
                $vendor             = $this->getVendor($refClass->getNamespaceName());
                $classes[] = $class;
            }
        }

        return $classes;
    }

    /**
     * Returns plugin vendor from full namespace path
     *
     * @param $namespace
     *
     * @return mixed
     */
    private function getVendor($namespace)
    {
        $namespacePath = explode('\\', $namespace);

        return $namespacePath[0];
    }

    /**
     * Registers all extensions
     */
    private function registerExtensions()
    {
        foreach ($this->classes as $class) {
            $extension = new $class();
            $this->containerBuilder->registerExtension($extension);
            $this->containerBuilder->loadFromExtension($extension->getAlias());
        }
    }

    /**
     * Register routing definition found in extension
     */
    private function registerRoutes()
    {
        foreach ($this->classes as $class) {
            $extension = new $class();
            $extension->registerRoutes($this->routeCollection, $this->containerBuilder);
        }
    }

    /**
     * Triggers post-process function in extension.
     * May be used to quickly override other DI definitions.
     */
    private function postProcess()
    {
        foreach ($this->classes as $class) {
            $extension = new $class();
            $extension->postProcess($this->containerBuilder);
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