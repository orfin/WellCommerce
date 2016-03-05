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

namespace WellCommerce\Bundle\ProductBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\AbstractConfigureDynamicRoutingPass;
use WellCommerce\Bundle\ProductBundle\DependencyInjection\WellCommerceProductExtension;

/**
 * Class ConfigureDynamicRoutingPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConfigureDynamicRoutingPass extends AbstractConfigureDynamicRoutingPass
{
    protected function getExtensionConfiguration(ContainerBuilder $container)
    {
        return $container->getParameter(WellCommerceProductExtension::EXTENSION_NAME);
    }
}
