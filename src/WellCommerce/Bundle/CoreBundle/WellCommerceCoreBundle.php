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

namespace WellCommerce\Bundle\CoreBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\FormResolverPass;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\ResourceProviderPass;

/**
 * Class WellCommerceCoreBundle
 *
 * @package WellCommerce\Bundle\CoreBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ResourceProviderPass());
        $container->addCompilerPass(new FormResolverPass());
    }
}
