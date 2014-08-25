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

namespace WellCommerce\Bundle\LayoutBundle\Manager;

/**
 * Interface LayoutInterface
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutInterface
{
    const CACHE_TTL = 3600;

    /**
     * Returns layout name
     *
     * @return string
     */
    public function getName();

    /**
     * Returns information whether layout cache is enabled or not
     *
     * @return bool
     */
    public function isCacheEnabled();

    /**
     * Returns cache lifetime for layout
     *
     * @return int
     */
    public function getCacheTtl();
} 