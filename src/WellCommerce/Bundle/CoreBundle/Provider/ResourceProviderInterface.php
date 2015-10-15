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

use WellCommerce\Bundle\CoreBundle\Entity\ResourceInterface;

/**
 * Interface ProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ResourceProviderInterface
{
    /**
     * Returns the current resource if set.
     * May throw an exception if strict mode is set to true
     *
     * @param bool|true $strict
     *
     * @return ResourceInterface|null
     */
    public function getResource($strict = true);

    /**
     * Sets current resource instance
     *
     * @param object|ResourceInterface $resource
     */
    public function setResource(ResourceInterface $resource);

    /**
     * Checks whether resource has been set
     *
     * @return bool
     */
    public function hasResource();

    /**
     * Returns the resource's identifier
     *
     * @return int
     */
    public function getResourceIdentifier();
}
