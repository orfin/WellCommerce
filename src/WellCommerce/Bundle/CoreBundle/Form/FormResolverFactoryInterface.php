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

namespace WellCommerce\Bundle\CoreBundle\Form;

/**
 * Interface FormResolverFactoryInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormResolverFactoryInterface
{
    /**
     * Resolves form service
     *
     * @param string $type  Resolver type
     * @param string $alias Service alias
     *
     * @return mixed
     */
    public function resolve($type, $alias);
} 