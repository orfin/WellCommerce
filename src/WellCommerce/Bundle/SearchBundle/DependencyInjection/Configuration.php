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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Configuration as BaseConfiguration;
use WellCommerce\Bundle\SearchBundle\Type\IndexType;

/**
 * Class Configuration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Configuration extends BaseConfiguration
{
    //@formatter:off
    protected function addCustomConfigurationNode()
    {
        $builder = new TreeBuilder();
        $node    =
            $builder->root('engine')
                ->children()
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
                                        ->scalarNode('class')->defaultValue(IndexType::class)->end()
                                        ->arrayNode('mapping')
                                            ->useAttributeAsKey('name')
                                            ->prototype('array')
                                                ->children()
                                                    ->booleanNode('indexable')->defaultValue(true)->isRequired()->end()
                                                    ->floatNode('boost')->defaultValue(1)->isRequired()->end()
                                                    ->scalarNode('value_expression')->isRequired()->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $node;
    }
    //@formatter:on
}
