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
namespace WellCommerce\Core\DependencyInjection\Builder;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\Compiler\RegisterTwigExtensionsPass;
use WellCommerce\Core\DependencyInjection\Extension\PluginExtensionLoader;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use WellCommerce\Core\DependencyInjection\Schema\Dumper;

/**
 * Class ServiceContainerBuilder
 *
 * @package WellCommerce\Core\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ServiceContainerBuilder
{
    /**
     * Cached container class name
     *
     * @var string
     */
    const SERVICE_CONTAINER_CLASS = 'ServiceContainer';

    /**
     * Class name for table info helper
     *
     * @var string
     */
    const DATABASE_COLUMNS_CLASS = 'TableInfo';

    /**
     * Cached container parent class name
     *
     * @var string
     */
    const SERVICE_CONTAINER_BASE_CLASS = 'Container';

    /**
     * Container builder instance
     *
     * @var object
     */
    protected $containerBuilder;

    /**
     * Array containing default kernel parameters used in configuring services
     *
     * @var array
     */
    protected $parameters;

    /**
     * True if the debug mode is enabled, false otherwise
     *
     * @var bool
     */
    protected $debug;

    /**
     * Application environment
     *
     * @var string
     */
    protected $environment;

    /**
     * Compiler passes registered to run during container build process
     *
     * @var array
     */
    protected $compilerPasses;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * Constructor
     *
     * @param array $parameters
     * @param bool  $debug
     */
    public function __construct(array $parameters, $environment, $debug = false)
    {
        $this->parameters     = $parameters;
        $this->environment    = $environment;
        $this->debug          = (bool)$debug;
        $this->containerClass = $this->getContainerClass();
        $this->initializeContainer();
    }

    /**
     * Returns cached container class name
     *
     * @return string
     */
    private function getContainerClass()
    {
        return self::SERVICE_CONTAINER_CLASS . ucfirst($this->environment) . ($this->debug ? 'Debug' : '');
    }

    /**
     * Returns container object
     *
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Returns path to cache dir
     *
     * @return string
     */
    public function getCacheDir()
    {
        return ROOTPATH . 'var' . DS . $this->environment;
    }

    /**
     * Initializes the Container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function initializeContainer()
    {
        $class = $this->getContainerClass();
        $cache = new ConfigCache($this->getCacheDir() . DS . $class . '.php', $this->debug);

        if (!$cache->isFresh()) {

            $parameterBag     = new ParameterBag($this->parameters);
            $containerBuilder = new ContainerBuilder($parameterBag);

            $this->registerExtensions($containerBuilder);
            $this->loadConfiguration($containerBuilder);

            $this->registerCompilerPasses();
//            $this->dumpDatabaseColumns($containerBuilder);

            foreach ($this->compilerPasses as $compilerPass) {
                $containerBuilder->addCompilerPass($compilerPass, PassConfig::TYPE_OPTIMIZE);
                $compilerPass->process($containerBuilder);
            }

            $containerBuilder->compile();

            $dumper  = new PhpDumper($containerBuilder);
            $content = $dumper->dump([
                'class'      => $this->getContainerClass(),
                'base_class' => self::SERVICE_CONTAINER_BASE_CLASS
            ]);

            $cache->write($content, $containerBuilder->getResources());
        }

        require_once $cache;

        $this->container = new $class();
    }

    /**
     * Dumps all database column names into one class
     *
     * @return void
     */
    private function dumpDatabaseColumns(ContainerBuilder $builder)
    {
        $dumper = new Dumper($builder);

        $path       = __DIR__ . '/../' . DS . 'Helper' . DS . self::DATABASE_COLUMNS_CLASS . '.php';
        $filesystem = new Filesystem();
        $filesystem->dumpFile($path, $dumper->dump([
            'class'     => self::DATABASE_COLUMNS_CLASS,
            'namespace' => 'WellCommerce\\Core\\Helper',
            'path'      => ROOTPATH . 'WellCommerce' . DS . 'Core' . DS . 'Helper' . DS . self::DATABASE_COLUMNS_CLASS . '.php'
        ]));
    }


    /**
     * Registers application extensions
     *
     * @param ContainerBuilder $builder
     */
    protected function registerExtensions(ContainerBuilder $builder)
    {
        $routeCollection = new RouteCollection();
        $extensionLoader = new PluginExtensionLoader($builder, $routeCollection);
        $extensionLoader->register();
        $extensionLoader->dumpRouting();
    }

    /**
     * Loads services configuration
     *
     * @param ContainerBuilder $builder
     */
    protected function loadConfiguration(ContainerBuilder $builder)
    {
        $locator = new FileLocator(ROOTPATH . 'config');
        $loader  = new YamlFileLoader($builder, $locator);
        $loader->load('config_dev.yml');
    }

    /**
     * Registers Compiler passes used in process of compiling the container
     *
     * @param CompilerPassInterface $compilerPass
     *
     * @return void
     */
    protected function registerCompilerPass(CompilerPassInterface $compilerPass)
    {
        $this->compilerPasses[] = $compilerPass;
    }

    /**
     * Register all required compiler passes
     *
     * @return void
     */
    protected function registerCompilerPasses()
    {
        // RegisterListenersPass for all event listeners
        $this->registerCompilerPass(new RegisterListenersPass());

        // RegisterTwigExtensionsPass for all services tagged with twig.extension
        $this->registerCompilerPass(new RegisterTwigExtensionsPass());

        $finder    = new Finder();
        $files     = $finder->files()->in(ROOTPATH . 'application')->name('*Pass.php');
        $interface = 'Symfony\\Component\\DependencyInjection\\Compiler\\CompilerPassInterface';
        foreach ($files as $file) {
            $namespace    = $file->getRelativePath();
            $compilerPass = $namespace . '\\' . $file->getBasename('.php');
            $refClass     = new \ReflectionClass($compilerPass);
            if ($refClass->implementsInterface($interface)) {
                $this->registerCompilerPass(new $compilerPass);
            }
        }
    }
}