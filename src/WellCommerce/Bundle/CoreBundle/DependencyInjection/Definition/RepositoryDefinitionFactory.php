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

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RepositoryDefinitionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class RepositoryDefinitionFactory
{
    public function create(string $class) : Definition
    {
        $definition = new Definition(EntityManager::class);
        $definition->setFactory([new Reference('doctrine.orm.entity_manager'), 'getRepository']);
        $definition->addArgument($class);
        
        return $definition;
    }
}
