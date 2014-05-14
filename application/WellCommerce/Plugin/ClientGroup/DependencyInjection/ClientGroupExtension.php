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

namespace WellCommerce\Plugin\ClientGroup\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class ClientGroupExtension
 *
 * @package WellCommerce\Plugin\ClientGroup\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupExtension extends AbstractExtension
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
    public function registerRoutes(RouteCollection $collection)
    {
        $extensionCollection = new RouteCollection();

        $extensionCollection->add('admin.client_group.index', new Route('/index', array(
            '_controller' => 'client_group.admin.controller:indexAction',
        )));

        $extensionCollection->add('admin.client_group.add', new Route('/add', array(
            '_controller' => 'client_group.admin.controller:addAction',
        )));

        $extensionCollection->add('admin.client_group.edit', new Route('/edit/{id}', array(
            '_controller' => 'client_group.admin.controller:editAction',
            'id'          => null
        )));

        $extensionCollection->addPrefix('/admin/client/group');

        $collection->addCollection($extensionCollection);
    }
}