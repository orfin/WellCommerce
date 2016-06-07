<?php

/*
 * This file is part of the Ivory Lucene Search package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\DoctrineBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;
use WellCommerce\Bundle\DoctrineBundle\Manager\Manager;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

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
        $rootNode    = $treeBuilder->root('well_commerce_doctrine');
        $this->processConfiguration($rootNode);

        return $treeBuilder;
    }

    //@formatter:off
    protected function processConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('configuration')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('manager')->defaultValue(Manager::class)->end()
                            ->scalarNode('repository')->defaultFalse()->treatNullLike(EntityRepository::class)->end()
                            ->scalarNode('factory')->defaultFalse()->treatNullLike(EntityFactory::class)->end()
                            ->scalarNode('entity')->isRequired()->end()
                            ->scalarNode('mapping')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    //@formatter:on
}
