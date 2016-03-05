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

namespace WellCommerce\Bundle\CategoryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use WellCommerce\Bundle\CategoryBundle\DependencyInjection\WellCommerceCategoryExtension;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\AbstractConfigureDynamicRoutingPass;

/**
 * Class ConfigureDynamicRoutingPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConfigureDynamicRoutingPass extends AbstractConfigureDynamicRoutingPass
{
    protected function getExtensionConfiguration(ContainerBuilder $container)
    {
        return $container->getParameter(WellCommerceCategoryExtension::EXTENSION_NAME);
    }
}
