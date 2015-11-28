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

namespace WellCommerce\Bundle\AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ThemeCompilerPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * Created on base of the LiipAppBundle <https://github.com/liip/LiipAppBundle>
 *
 * Special thanks goes to its authors and contributors
 */
class ThemeCompilerPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $container->setAlias('templating.locator', 'theme.templating_locator');
        $container->setAlias('templating.cache_warmer.template_paths', 'theme.template_paths.cache_warmer');
    }
}
