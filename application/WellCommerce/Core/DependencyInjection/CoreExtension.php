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

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class CoreExtension
 *
 * @package WellCommerce\Core\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CoreExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('datagrid.xml');
        $loader->load('dataset.xml');

        $this->registerDatabaseConfiguration($config['database'], $container, $loader);
        $this->registerRouterConfiguration($config['router'], $container, $loader);
        $this->registerSessionConfiguration($config['session'], $container, $loader);
        $this->registerTemplateConfiguration($config['session'], $container, $loader);
    }

    /**
     * Registers database configuration
     *
     * @param                  $config
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     */
    private function registerDatabaseConfiguration($config, ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->setParameter('database.driver', $config['driver']);
        $container->setParameter('database.host', $config['host']);
        $container->setParameter('database.database', $config['database']);
        $container->setParameter('database.username', $config['username']);
        $container->setParameter('database.password', $config['password']);
        $container->setParameter('database.charset', $config['charset']);
        $container->setParameter('database.collation', $config['collation']);
        $container->setParameter('database.prefix', $config['prefix']);

        $loader->load('database.xml');
    }

    /**
     * Registers router configuration
     *
     * @param                  $config
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     */
    private function registerRouterConfiguration($config, ContainerBuilder $container, LoaderInterface $loader)
    {
        $loader->load('routing.xml');

        $container->setParameter('router.cache_dir', $config['cache_dir']);
        $container->setParameter('router.generator_cache_class', $config['generator_cache_class']);
        $container->setParameter('router.matcher_cache_class', $config['matcher_cache_class']);
    }

    /**
     * Registers session configuration
     *
     * @param                  $config
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     */
    private function registerSessionConfiguration($config, ContainerBuilder $container, LoaderInterface $loader)
    {
        $loader->load('session.xml');

        $container->setParameter('session.db_table', $config['db_table']);
    }

    /**
     * Registers template configuration
     *
     * @param                  $config
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     */
    private function registerTemplateConfiguration($config, ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->setParameter('front_themes', [
            $container->getParameter('application.themes_path') . '/WellCommerce/templates'
        ]);

        $container->setParameter('admin_themes', [
            $container->getParameter('application.design_path') . '/templates'
        ]);

        $loader->load('template.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function registerRoutes(RouteCollection $collection, ContainerBuilder $container)
    {
        $extensionCollection = new RouteCollection();

        $extensionCollection->add('admin.company.index', new Route('/index', array(
            '_controller' => 'company.admin.controller:indexAction',
        )));

        $extensionCollection->add('admin.company.add', new Route('/add', array(
            '_controller' => 'company.admin.controller:addAction',
        )));

        $extensionCollection->add('admin.company.edit', new Route('/edit/{id}', array(
            '_controller' => 'company.admin.controller:editAction',
            'id'          => null
        )));

        $extensionCollection->addPrefix('/admin/company');

        $collection->addCollection($extensionCollection);
    }
}