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

namespace WellCommerce\CoreBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WellCommerce\CoreBundle\DependencyInjection\Compiler\DataSetContextPass;
use WellCommerce\CoreBundle\DependencyInjection\Compiler\DataSetTransformerPass;
use WellCommerce\CoreBundle\DependencyInjection\Compiler\FormDataTransformerPass;
use WellCommerce\CoreBundle\DependencyInjection\Compiler\FormResolverPass;

/**
 * Class WellCommerceCoreBundle
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceCoreBundle extends Bundle
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
