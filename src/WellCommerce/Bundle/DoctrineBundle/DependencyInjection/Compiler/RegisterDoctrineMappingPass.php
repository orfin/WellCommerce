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

namespace WellCommerce\Bundle\DoctrineBundle\DependencyInjection\Compiler;

use Mmoreram\SimpleDoctrineMapping\CompilerPass\Abstracts\AbstractMappingCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RegisterClassMetadataEnhancerPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class RegisterDoctrineMappingPass extends AbstractMappingCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getParameter('doctrine_orm_mapping_map') as $entity => $mapping) {
            $this->addEntityMapping($container, 'default', $entity, $mapping);
        }
    }
}
