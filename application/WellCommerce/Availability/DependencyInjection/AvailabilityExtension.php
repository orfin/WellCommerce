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

namespace WellCommerce\Availability\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Loader\XmlFileLoader as RoutingLoader;
use WellCommerce\Core\DependencyInjection\AbstractExtension;
use WellCommerce\Language\Model\Language;

/**
 * Class AvailabilityExtension
 *
 * @package WellCommerce\Availability\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityExtension extends AbstractExtension
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

        $extensionCollection->add('admin.availability.index', new Route('/index', array(
            '_controller' => 'availability.admin.controller:indexAction',
        )));

        $extensionCollection->add('admin.availability.add', new Route('/add', array(
            '_controller' => 'availability.admin.controller:addAction',
        )));

        $extensionCollection->add('admin.availability.edit', new Route('/edit/{id}', array(
            '_controller' => 'availability.admin.controller:editAction',
            'id'          => null
        )));

        $extensionCollection->addPrefix('/admin/availability');

        $collection->addCollection($extensionCollection);
    }
}
