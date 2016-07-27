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
 * Class AdminControllerDefinitionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class AdminControllerDefinitionFactory
{
    public function create(string $class, Reference $manager = null, Reference $formBuilder = null, Reference $dataGrid = null) : Definition
    {
        $definition = new Definition();
        $definition->setClass($class);
        $definition->addArgument($manager);
        $definition->addArgument($formBuilder);
        $definition->addArgument($dataGrid);
        $definition->addMethodCall('setContainer', [new Reference('service_container')]);
        
        return $definition;
    }
}
