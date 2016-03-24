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

namespace WellCommerce\Component\Form\Resolver;

/**
 * Interface FormResolverCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormResolverFactoryInterface
{
    /**
     * Adds new resolver to stack
     *
     * @param                   $type
     * @param ResolverInterface $resolver
     */
    public function addResolver($type, ResolverInterface $resolver);

    /**
     * Checks whether resolver is available
     *
     * @param $type
     *
     * @return bool
     */
    public function hasResolver($type);

    /**
     * Returns resolver instance by type
     *
     * @param $type
     *
     * @return ResolverInterface
     */
    public function getResolver($type);

    /**
     * Resolves service alias using resolver service
     *
     * @param $type
     * @param $alias
     *
     * @return string
     */
    public function resolve($type, $alias);
}
