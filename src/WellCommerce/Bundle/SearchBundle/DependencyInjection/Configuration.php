<?php

/*
 * This file is part of the Ivory Lucene Search package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\SearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('well_commerce_search');
        $this->processConfiguration($rootNode);

        return $treeBuilder;
    }

    //@formatter:off
    protected function processConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('engine')
                    ->children()
                        ->arrayNode('quick_search')->isRequired()
                            ->children()
                                ->scalarNode('limit')->defaultValue(20)->end()
                                ->scalarNode('order_by')->defaultValue('score')->end()
                                ->enumNode('order_dir')->values(['asc', 'desc'])->defaultValue('asc')->end()
                            ->end()
                        ->end()
                        ->arrayNode('adapters')->isRequired()
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('class')->isRequired()->end()
                                    ->arrayNode('options')
                                        ->useAttributeAsKey('name')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('index')->isRequired()
                            ->children()
                                ->arrayNode('types')->isRequired()
                                    ->useAttributeAsKey('name')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('class')->isRequired()->end()
                                            ->arrayNode('mapping')
                                                ->useAttributeAsKey('name')
                                                ->prototype('array')
                                                    ->children()
                                                        ->booleanNode('indexable')->defaultValue(true)->isRequired()->end()
                                                        ->floatNode('boost')->defaultValue(1)->isRequired()->end()
                                                        ->floatNode('fuzziness')->defaultValue(1)->isRequired()->end()
                                                        ->scalarNode('value_expression')->isRequired()->end()
                                                    ->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    //@formatter:on
}
