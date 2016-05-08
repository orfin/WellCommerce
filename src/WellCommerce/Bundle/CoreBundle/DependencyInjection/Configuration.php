<?php

/*
 * This file is part of the Ivory Lucene Search package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use WellCommerce\Bundle\ApiBundle\Request\RequestHandler;
use WellCommerce\Bundle\DoctrineBundle\Manager\Manager;

/**
 * Class Configuration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
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
        }
        
        return $treeBuilder;
    }
    
    //@formatter:off
    protected function addBaseExtensionConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->append($this->addCustomConfigurationNode())
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
                                    ->scalarNode('request_handler')->defaultValue(RequestHandler::class)->end()
                                ->end()
                            ->end()
                            ->arrayNode('dynamic_routing')
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
                    ->end()
                ->end()
            ->end();
    }

    protected function addCustomConfigurationNode()
    {
        return new ArrayNodeDefinition('custom');
    }
    //@formatter:on
}
