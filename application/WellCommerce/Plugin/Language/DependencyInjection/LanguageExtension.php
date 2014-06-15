<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This language is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE language that was distributed with this source code.
 */
namespace WellCommerce\Plugin\Language\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WellCommerce\Core\DependencyInjection\AbstractExtension;

/**
 * Class LanguageExtension
 *
 * @package WellCommerce\Plugin\Language\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LanguageExtension extends AbstractExtension
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

        $extensionCollection->add('admin.language.index', new Route('/index', array(
            '_controller' => 'language.admin.controller:indexAction',
        )));

        $extensionCollection->add('admin.language.add', new Route('/add', array(
            '_controller' => 'language.admin.controller:addAction',
        )));

        $extensionCollection->add('admin.language.edit', new Route('/edit/{id}', array(
            '_controller' => 'language.admin.controller:editAction',
            'id'          => null
        )));

        $extensionCollection->addPrefix('/admin/language');

        $collection->addCollection($extensionCollection);
    }
}