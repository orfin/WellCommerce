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

namespace WellCommerce\Core\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package WellCommerce\Core\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('wellcommerce_core');

        $this->addDatabaseSection($rootNode);
        $this->addRouterSection($rootNode);
        $this->addSessionSection($rootNode);
        $this->addThemesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Parses configuration for database node
     *
     * @param ArrayNodeDefinition $rootNode
     */
    private function addDatabaseSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('database')
            ->info('Database configuration')
            ->children()
            ->scalarNode('driver')->defaultValue('mysql')->end()
            ->scalarNode('host')->defaultValue('localhost')->end()
            ->scalarNode('database')->isRequired()->end()
            ->scalarNode('username')->defaultValue('root')->end()
            ->scalarNode('port')->defaultValue('3306')->end()
            ->scalarNode('password')->defaultValue('')->end()
            ->scalarNode('charset')->defaultValue('utf8')->end()
            ->scalarNode('collation')->defaultValue('utf8_unicode_ci')->end()
            ->scalarNode('prefix')->defaultValue('prefix')->end()
            ->end()
            ->end()
            ->end();
    }

    /**
     * Parses configuration for router node
     *
     * @param ArrayNodeDefinition $rootNode
     */
    private function addRouterSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('router')
            ->info('Router configuration')
            ->children()
            ->scalarNode('cache_dir')->isRequired()->end()
            ->scalarNode('generator_cache_class')->defaultValue('WellCommerceUrlGenerator')->end()
            ->scalarNode('matcher_cache_class')->defaultValue('WellCommerceUrlMatcher')->end()
            ->end()
            ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function addSessionSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('session')
            ->info('Session configuration')
            ->children()
            ->scalarNode('db_table')->defaultValue('session')->end()
            ->end()
            ->end()
            ->end();
    }

    private function addThemesSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('themes')
            ->info('Themes configuration')
            ->children()
            ->arrayNode('front')->isRequired()->end()
            ->arrayNode('admin')->isRequired()->end()
            ->end()
            ->end()
            ->end();
    }
} 