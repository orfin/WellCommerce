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

namespace WellCommerce\AppBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WellCommerce\AppBundle\DependencyInjection\Compiler\DataSetContextPass;
use WellCommerce\AppBundle\DependencyInjection\Compiler\DataSetTransformerPass;
use WellCommerce\AppBundle\DependencyInjection\Compiler\FormDataTransformerPass;
use WellCommerce\AppBundle\DependencyInjection\Compiler\FormResolverPass;

/**
 * Class WellCommerceAppBundle
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceAppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FormResolverPass());
        $container->addCompilerPass(new FormDataTransformerPass());
        $container->addCompilerPass(new DataSetContextPass());
        $container->addCompilerPass(new DataSetTransformerPass());
    }
}
