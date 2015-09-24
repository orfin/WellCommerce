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

namespace WellCommerce\Bundle\CartBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WellCommerce\Bundle\CartBundle\DependencyInjection\Compiler\RegisterCartVisitorPass;

/**
 * Class WellCommerceCartBundle
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceCartBundle extends Bundle
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
    }
}
