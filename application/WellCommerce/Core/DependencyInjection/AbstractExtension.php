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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Routing\RouteCollection;

abstract class AbstractExtension extends Extension
{
    const SCHEMA_URL = 'http://symfony.com/schema/dic/services';

    /**
     * Loads the extension
     *
     * @param array            $config
     * @param ContainerBuilder $container
     *
     * @return mixed
     */
    abstract public function load(array $config, ContainerBuilder $container);

    /**
     * Returns the namespace to be used for this extension
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return self::SCHEMA_URL;
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
        $name   = str_replace('Extension', '', $r->getShortName());

        return strtolower(sprintf('%s_%s', $vendor, $name));
    }

    /**
     * Registers routes for this extension
     *
     * @param RouteCollection $collection Route collection
     */
    abstract public function registerRoutes(RouteCollection $collection, ContainerBuilder $container);

    /**
     *
     * @param ContainerBuilder $container
     *
     * @return mixed
     */
    public function postProcess(ContainerBuilder $container)
    {
        return false;
    }
}