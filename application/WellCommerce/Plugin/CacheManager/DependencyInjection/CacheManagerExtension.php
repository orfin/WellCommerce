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

namespace WellCommerce\Plugin\CacheManager\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class CacheManagerExtension
 *
 * @package WellCommerce\Plugin\CacheManager\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CacheManagerExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function registerRoutes(RouteCollection $collection, ContainerBuilder $container)
    {
        $extensionCollection = new RouteCollection();

        $extensionCollection->add('admin.cache_manager.index', new Route('/index', array(
            '_controller' => 'cache_manager.admin.controller:indexAction',
        )));

        $extensionCollection->add('admin.cache_manager.add', new Route('/add', array(
            '_controller' => 'cache_manager.admin.controller:addAction',
        )));

        $extensionCollection->add('admin.cache_manager.edit', new Route('/edit/{id}', array(
            '_controller' => 'cache_manager.admin.controller:editAction',
            'id'          => null
        )));

        $extensionCollection->addPrefix('/admin/cache_manager');

        $collection->addCollection($extensionCollection);
    }
}