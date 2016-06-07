<?php

/*
 * This file is part of the Ivory Lucene Search package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use WellCommerce\Bundle\ApiBundle\Handler\RequestHandler;

/**
 * Class Configuration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('well_commerce_api');
        $this->processConfiguration($rootNode);

        return $treeBuilder;
    }
    
    //@formatter:off
    protected function processConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('request_handler')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->scalarNode('manager')->isRequired()->end()
                            ->scalarNode('class')->defaultValue(RequestHandler::class)->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('serialization')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('mapping')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    //@formatter:on
}
