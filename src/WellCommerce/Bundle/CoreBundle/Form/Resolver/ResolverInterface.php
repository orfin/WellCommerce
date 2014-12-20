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
 * Interface ResolverInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Resolver
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ResolverInterface
{
    /**
     * Guesses service name by type
     *
     * @param $type
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @return mixed
     */
    public function guess($type);

    /**
     * Returns resolved service
     *
     * @param       $type
     * @param array $options
     *
     * @return mixed
     */
    public function get($type, array $options = []);

    /**
     * Returns service name pattern
     *
     * @return string
     */
    public function getServiceNamePattern();
} 