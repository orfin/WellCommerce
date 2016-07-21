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
 * Class FormBuilderDefinitionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class FormBuilderDefinitionFactory
{
    public function create(string $class) : Definition
    {
        $definition = new Definition($class);
        $definition->addArgument(new Reference('form.resolver.factory'));
        $definition->addArgument(new Reference('form.handler'));
        $definition->addArgument(new Reference('event_dispatcher'));
        $definition->addMethodCall('setContainer', [new Reference('service_container')]);
        
        return $definition;
    }
}
