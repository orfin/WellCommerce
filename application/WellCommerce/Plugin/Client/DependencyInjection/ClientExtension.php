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

namespace WellCommerce\Plugin\Client\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class ClientExtension
 *
 * @package WellCommerce\Plugin\Client\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientExtension extends AbstractExtension
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

        $extensionCollection->add('admin.client.index', new Route('/index', array(
            '_controller' => 'client.admin.controller:indexAction',
        )));

        $extensionCollection->add('admin.client.add', new Route('/add', array(
            '_controller' => 'client.admin.controller:addAction',
        )));

        $extensionCollection->add('admin.client.edit', new Route('/edit/{id}', array(
            '_controller' => 'client.admin.controller:editAction',
            'id'          => null
        )));

        $extensionCollection->addPrefix('/admin/client');

        $collection->addCollection($extensionCollection);
    }
}
