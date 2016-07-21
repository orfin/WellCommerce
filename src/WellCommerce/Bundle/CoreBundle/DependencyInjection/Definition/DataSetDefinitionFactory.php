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

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class DataSetDefinitionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class DataSetDefinitionFactory
{
    public function create(string $repositoryServiceId, string $class) : Definition
    {
        $definition = new Definition();
        $definition->setClass($class);
        $definition->addArgument(new Reference($repositoryServiceId));
        $definition->addArgument(new Reference('dataset.manager'));
        $definition->addArgument(new Reference('event_dispatcher'));
        $definition->setConfigurator([new Reference('dataset.configurator'), 'configure']);
        
        return $definition;
    }
}
