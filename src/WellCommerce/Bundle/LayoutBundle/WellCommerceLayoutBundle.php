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

namespace WellCommerce\Bundle\LayoutBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WellCommerce\Bundle\LayoutBundle\DependencyInjection\Compiler\LayoutPagesPass;
use WellCommerce\Bundle\LayoutBundle\DependencyInjection\Compiler\TemplateResourcesPass;
use WellCommerce\Bundle\LayoutBundle\DependencyInjection\Compiler\ThemeCompilerPass;

/**
 * Class WellCommerceLayoutBundle
 *
 * @package WellCommerce\Bundle\LayoutBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * Inspired by LiipThemeBundle <https://github.com/liip/LiipThemeBundle>
 *
 * Special thanks goes to its authors and contributors
 */
class WellCommerceLayoutBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ThemeCompilerPass());
        $container->addCompilerPass(new TemplateResourcesPass());
        $container->addCompilerPass(new LayoutPagesPass());
    }
}
