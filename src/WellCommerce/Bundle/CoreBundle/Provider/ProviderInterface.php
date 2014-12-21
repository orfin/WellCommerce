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

namespace WellCommerce\Bundle\CoreBundle\Provider;

/**
 * Interface ProviderInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Provider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProviderInterface
{
    /**
     * Returns provider type
     *
     * @return mixed
     */
    public function getType();

    /**
     * Sets current providers resource
     *
     * @param $resource
     *
     * @return mixed
     */
    public function setCurrentResource($resource);

    /**
     * Returns current resource
     *
     * @return mixed
     */
    public function getCurrentResource();
} 