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

namespace WellCommerce\SalesBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WellCommerce\SalesBundle\DependencyInjection\Compiler\RegisterCartVisitorPass;
use WellCommerce\SalesBundle\DependencyInjection\Compiler\RegisterOrderVisitorPass;
use WellCommerce\SalesBundle\DependencyInjection\Compiler\RegisterPaymentMethodProcessorPass;
use WellCommerce\SalesBundle\DependencyInjection\Compiler\RegisterShippingMethodCalculatorPass;

/**
 * Class WellCommerceSalesBundle
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceSalesBundle extends Bundle
{
    /**
     * Builds the container for bundle
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterCartVisitorPass());
        $container->addCompilerPass(new RegisterOrderVisitorPass());
        $container->addCompilerPass(new RegisterShippingMethodCalculatorPass());
        $container->addCompilerPass(new RegisterPaymentMethodProcessorPass());
    }
}
