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

namespace WellCommerce\User\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class UserExtension
 *
 * @package WellCommerce\User\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserExtension extends AbstractExtension
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

        $extensionCollection->add('admin.user.index', new Route('/index', array(
            '_controller' => 'user.admin.controller:indexAction',
        )));

        $extensionCollection->add('admin.user.add', new Route('/add', array(
            '_controller' => 'user.admin.controller:addAction',
        )));

        $extensionCollection->add('admin.user.edit', new Route('/edit/{id}', array(
            '_controller' => 'user.admin.controller:editAction',
            'id'          => null
        )));

        $extensionCollection->add('admin.user.login', new Route('/login', array(
            '_controller' => 'user.admin.controller:loginAction'
        )));

        $extensionCollection->add('admin.user.logout', new Route('/logout', array(
            '_controller' => 'user.admin.controller:logoutAction'
        )));

        $extensionCollection->addPrefix('/admin/user');

        $collection->addCollection($extensionCollection);
    }
}
