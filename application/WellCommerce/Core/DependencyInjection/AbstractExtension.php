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

namespace WellCommerce\Core\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class AbstractExtension extends Extension
{
    abstract public function load(array $config, ContainerBuilder $container);

    public function getNamespace()
    {
        return 'http://symfony.com/schema/dic/services';
    }

    /**
     * Resolves extension alias
     *
     * @return string
     */
    public function getAlias()
    {
        $r      = new \ReflectionObject($this);
        $parts  = explode('\\', $r->getNamespaceName());
        $vendor = array_shift($parts);

        return strtolower(sprintf('%s.%s', $vendor, $r->getShortName()));
    }
} 