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

namespace WellCommerce\Bundle\SearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractExtension;
use WellCommerce\Bundle\SearchBundle\Manager\SearchEngineManager;

/**
 * Class WellCommerceSearchExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class WellCommerceSearchExtension extends AbstractExtension
{
    protected function processExtensionConfiguration(array $configuration, ContainerBuilder $container)
    {
        parent::processExtensionConfiguration($configuration, $container);

        $defaultEngine = $container->getParameter('search_engine');
        $engines       = $configuration['engines'];

        $engine = $engines[$defaultEngine] ?? current($engines);

        $this->createSearchManager($engine, $container);
    }

    private function createSearchManager(array $engine, ContainerBuilder $container)
    {
        $queryBuilderName = 'search.engine.query_builder';
        $queryBuilder     = new Definition($engine['query_builder']['class']);
        $queryBuilder->setPublic(false);
        $container->setDefinition($queryBuilderName, $queryBuilder);

        $adapterName = 'search.engine.adapter';
        $adapter     = new Definition($engine['adapter']['class']);
        $adapter->addArgument($engine['adapter']['options']);
        $adapter->setPublic(false);
        $container->setDefinition($adapterName, $adapter);

        $managerName = 'search.engine.manager';
        $manager     = new Definition(SearchEngineManager::class);
        $manager->addArgument(new Reference($adapterName));
        $manager->addArgument(new Reference($queryBuilderName));
        $manager->addArgument(new Reference('search.result.storage'));
        $container->setDefinition($managerName, $manager);
    }
}
