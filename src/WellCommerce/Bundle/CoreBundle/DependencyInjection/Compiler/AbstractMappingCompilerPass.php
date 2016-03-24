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

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler;

use Mmoreram\SimpleDoctrineMapping\CompilerPass\Abstracts\AbstractMappingCompilerPass as BaseAbstractMappingCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class AbstractMappingCompilerPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractMappingCompilerPass extends BaseAbstractMappingCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $parameters = $this->getExtensionConfiguration($container);

        foreach ($parameters['services'] as $moduleName => $config) {
            $entity  = $config['orm_configuration']['entity'];
            $mapping = $config['orm_configuration']['mapping'];
            $this->addEntityMapping($container, 'default', $entity, $mapping);
        }
    }

    /**
     * @return array
     */
    abstract protected function getExtensionConfiguration(ContainerBuilder $container);
}
