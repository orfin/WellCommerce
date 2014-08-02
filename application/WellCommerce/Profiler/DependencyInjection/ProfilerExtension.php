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
namespace WellCommerce\Profiler\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class ProfilerExtension
 *
 * @package WellCommerce\Profiler\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProfilerExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        if (false === $container->getParameter('profiler_enabled')) {
            return;
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function registerRoutes(RouteCollection $collection, ContainerBuilder $container)
    {
        $adminCollection = new RouteCollection();

        $adminCollection->add('admin.profiler.index', new Route('/index', array(
            '_controller' => 'profiler.admin.controller:indexAction',
        )));

        $adminCollection->addPrefix('/admin/profiler');

        $collection->addCollection($adminCollection);
    }
}