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
namespace WellCommerce\Plugin\Category\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class CategoryExtension
 *
 * @package WellCommerce\Plugin\Category\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryExtension extends AbstractExtension
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

        $extensionCollection->add('admin.category.index', new Route('/index', array(
            '_controller' => 'category.admin.controller:indexAction',
        )));

        $extensionCollection->add('admin.category.add', new Route('/add', array(
            '_controller' => 'category.admin.controller:addAction',
        )));

        $extensionCollection->add('admin.category.edit', new Route('/edit/{id}', array(
            '_controller' => 'category.admin.controller:editAction',
            'id'          => null
        )));

        $extensionCollection->addPrefix('/admin/category');

        $collection->addCollection($extensionCollection);
    }
}