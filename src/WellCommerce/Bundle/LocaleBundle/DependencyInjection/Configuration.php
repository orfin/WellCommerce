<?php

/*
 * This file is part of the Ivory Lucene Search package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\LocaleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Configuration as BaseConfiguration;
use WellCommerce\Bundle\LocaleBundle\Copier\LocaleCopier;
use WellCommerce\Bundle\SearchBundle\Type\IndexType;

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
        $rootNode    = $treeBuilder->root('well_commerce_locale');
        $this->processConfiguration($rootNode);

        return $treeBuilder;
    }

    //@formatter:off
    protected function processConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('copier')
                    ->children()
                    ->scalarNode('class')->defaultValue(LocaleCopier::class)->end()
                    ->arrayNode('entities')->isRequired()
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->children()
                                ->arrayNode('properties')
                                    ->useAttributeAsKey('name')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    //@formatter:on
}
