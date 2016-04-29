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

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Manager;

/**
 * Class AbstractConfiguration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractConfiguration implements ConfigurationInterface
{
    protected $treeRoot;

    /**
     * AbstractConfiguration constructor.
     *
     * @param string $treeRoot
     */
    public function __construct(string $treeRoot)
    {
        $this->treeRoot = $treeRoot;
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        if (null !== $this->treeRoot) {
            $rootNode = $treeBuilder->root($this->treeRoot);
            $this->addBaseExtensionConfiguration($rootNode);
            $this->addCustomExtensionConfiguration($rootNode);
        }

        return $treeBuilder;
    }

    protected function addCustomExtensionConfiguration(ArrayNodeDefinition $node)
    {

    }

    //@formatter:off
    protected function addBaseExtensionConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('configuration')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('orm')->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('manager')->defaultValue(Manager::class)->end()
                                    ->scalarNode('repository')->defaultNull()->end()
                                    ->scalarNode('factory')->defaultNull()->end()
                                    ->scalarNode('entity')->isRequired()->end()
                                    ->scalarNode('mapping')->isRequired()->end()
                                ->end()
                            ->end()
                            ->arrayNode('api')
                                ->children()
                                    ->booleanNode('exposed')->defaultFalse()->end()
                                    ->scalarNode('dataset')->defaultNull()->end()
                                    ->scalarNode('manager')->defaultNull()->end()
                                ->end()
                            ->end()
                            ->arrayNode('dynamic_routing')
                                ->children()
                                    ->scalarNode('name')->isRequired()->end()
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
                                    ->scalarNode('pattern')->defaultNull()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    //@formatter:on
}
