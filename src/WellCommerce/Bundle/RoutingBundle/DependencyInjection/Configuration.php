<?php

/*
 * This file is part of the Ivory Lucene Search package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\RoutingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Configuration as BaseConfiguration;

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
        $rootNode    = $treeBuilder->root('well_commerce_routing');
        $this->processConfiguration($rootNode);
        
        return $treeBuilder;
    }
    
    //@formatter:off
    protected function processConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('routers')
                    ->defaultValue(['router.default' => 100])
                    ->useAttributeAsKey('id')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('dynamic_routing')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('entity')->isRequired()->end()
                            ->scalarNode('generator')->isRequired()->end()
                            ->arrayNode('defaults')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('requirements')
                               ->useAttributeAsKey('name')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('options')
                                ->children()
                                    ->arrayNode('breadcrumb')
                                        ->children()
                                            ->scalarNode('label')->isRequired()->end()
                                            ->scalarNode('css_class')->defaultValue('')->end()
                                            ->scalarNode('route')->defaultValue('')->end()
                                            ->scalarNode('parent_route')->defaultValue('')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->scalarNode('pattern')->defaultValue('')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    //@formatter:on
}
