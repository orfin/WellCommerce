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
namespace WellCommerce\Core\DependencyInjection;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
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
    protected $isDebug;

    /**
     * Compiler passes registered to run during container build process
     *
     * @var array
     */
    protected $compilerPasses;

    /**
     * Path to cached container class
     *
     * @var string
     */
    protected $compilerClassPath;

    /**
     * Config cache object
     *
     * @var ConfigCache
     */
    protected $containerConfigCache;

    /**
     * Constructor
     *
     * @param array $parameters
     * @param bool  $isDebug
     */
    public function __construct(array $parameters, $isDebug = false)
    {
        $this->parameters           = $parameters;
        $this->isDebug              = (bool)$isDebug;
        $this->compilerClassPath    = __DIR__ . DS . self::SERVICE_CONTAINER_CLASS . '.php';
        $this->containerConfigCache = new ConfigCache($this->compilerClassPath, $this->isDebug);
    }

    /**
     * Checks if optimised container class needs to be regenerated
     *
     * @return ServiceContainer
     */
    public function check()
    {
        if (!$this->containerConfigCache->isFresh()) {

            $this->initContainerBuilder();
            $this->loadXmlConfiguration();
            $this->registerExtensions();
            $this->registerCompilerPasses();
            $this->dumpDatabaseColumns();

            foreach ($this->compilerPasses as $compilerPass) {
                $this->containerBuilder->addCompilerPass($compilerPass, PassConfig::TYPE_OPTIMIZE);
                $compilerPass->process($this->containerBuilder);
            }

            $this->compileAndSaveContainer();
        }

        return new ServiceContainer();
    }

    /**
     * Dumps all database column names into one class
     *
     * @return void
     */
    private function dumpDatabaseColumns()
    {
        $dumper = new Dumper($this->containerBuilder);

        $options = Array(
            'class'     => self::DATABASE_COLUMNS_CLASS,
            'namespace' => 'WellCommerce\\Core\\Helper',
            'path'      => ROOTPATH . 'WellCommerce' . DS . 'Core' . DS . 'Helper' . DS . self::DATABASE_COLUMNS_CLASS . '.php'
        );

        $path       = __DIR__ . '/../' . DS . 'Helper' . DS . self::DATABASE_COLUMNS_CLASS . '.php';
        $filesystem = new Filesystem();
        $filesystem->dumpFile($path, $dumper->dump($options));
    }


    /**
     * Register extensions using recursive scan
     *
     * @return void
     */
    protected function registerExtensions()
    {
        $routeCollection = new RouteCollection();
        $extensionLoader = new PluginExtensionLoader($this->containerBuilder, $routeCollection);
        $extensionLoader->register();
        $extensionLoader->dumpRouting();
    }

    /**
     * Compiles container and saves it as an optimized class
     *
     * @return void
     */
    protected function compileAndSaveContainer()
    {
        $this->containerBuilder->compile();

        $dumper = new PhpDumper($this->containerBuilder);

        $options = Array(
            'class'      => self::SERVICE_CONTAINER_CLASS,
            'base_class' => self::SERVICE_CONTAINER_BASE_CLASS,
            'namespace'  => __NAMESPACE__
        );

        $content = $dumper->dump($options);

        $this->containerConfigCache->write($content, $this->containerBuilder->getResources());
    }

    /**
     * Initializes Container Builder instance
     *
     * @return void
     */
    protected function initContainerBuilder()
    {
        $parameterBag           = new ParameterBag($this->parameters);
        $this->containerBuilder = new ContainerBuilder($parameterBag);
    }

    /**
     * Loads services configuration and predefined parameters from XML config file
     *
     * @return void
     */
    protected function loadXmlConfiguration()
    {
        $locator = new FileLocator(ROOTPATH . 'config');
        $loader  = new XmlFileLoader($this->containerBuilder, $locator);

        $loader->load('parameters.xml');
        $loader->load('core.xml');
        $loader->load('database.xml');
        $loader->load('datagrid.xml');
        $loader->load('routing.xml');
        $loader->load('session.xml');
        $loader->load('template.xml');
    }

    /**
     * Registers Compiler passess used in process of compiling the container
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