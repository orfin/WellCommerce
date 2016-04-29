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
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractConfiguration;

/**
 * Class Configuration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Configuration extends AbstractConfiguration
{

    protected function addCustomExtensionConfiguration(ArrayNodeDefinition $node)
    {
        $node->children()
            ->arrayNode('routers')
            ->defaultValue(['router.default' => 100])
            ->useAttributeAsKey('id')
            ->prototype('scalar')->end()
            ->end()
            ->end();
    }
}
