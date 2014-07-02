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

namespace WellCommerce\Plugin\Cart\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class CartExtension
 *
 * @package WellCommerce\Plugin\Cart\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('layout.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function registerRoutes(RouteCollection $collection, ContainerBuilder $container)
    {
        // front routes
        $frontCollection = new RouteCollection();

        $frontCollection->add('front.cart.index', new Route('/cart', array(
            '_controller' => 'cart.front.controller:indexAction',
        )));

        $frontCollection->add('front.cart.add', new Route('/cart/add/{id},{variant},{qty}', array(
            '_controller' => 'cart.front.controller:addAction',
        )));

        $frontCollection->add('front.cart.delete', new Route('/cart/delete/{id}', array(
            '_controller' => 'cart.front.controller:deleteAction',
        )));

        $collection->addCollection($frontCollection);


    }
}