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
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ResourceProviderInterface
{
    /**
     * Returns the current resource if set
     *
     * @return object|null
     */
    public function getCurrentResource();

    /**
     * Sets current resource instance
     *
     * @param object $resource
     */
    public function setCurrentResource($resource);

    /**
     * Checks whether current resource has been set
     *
     * @return bool
     */
    public function hasCurrentResource();
}
