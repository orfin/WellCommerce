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

namespace WellCommerce\Bundle\CoreBundle\Form\Resolver;

/**
 * Interface ElementResolverInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Resolver
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ElementResolverInterface
{
    /**
     * Resolves and returns element service
     *
     * @param $type
     *
     * @throws \InvalidArgumentException if the service was not found
     * @return object
     */
    public function resolve($type);
} 