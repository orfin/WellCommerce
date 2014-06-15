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

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;
use WellCommerce\Plugin\Category\Model\CategoryTranslation;

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
    public function registerRoutes(RouteCollection $collection, ContainerBuilder $container)
    {
        // admin collection
        $adminCollection = new RouteCollection();

        $adminCollection->add('admin.category.index', new Route('/index', array(
            '_controller' => 'category.admin.controller:indexAction',
        )));

        $adminCollection->add('admin.category.edit', new Route('/edit/{id}', array(
            '_controller' => 'category.admin.controller:editAction',
            'id'          => null
        )));

        $adminCollection->addPrefix('/admin/category');

        $collection->addCollection($adminCollection);

        // frontend collection
        $frontendCollection = new RouteCollection();

        $frontendCollection->add('front.category.index', new Route('/{slug}', array(
            '_controller' => 'category.front.controller:indexAction',
            'slug'        => null
        )));

        $frontendCollection->addPrefix('/category');

        $collection->addCollection($frontendCollection);
    }
}