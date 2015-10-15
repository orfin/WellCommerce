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
 * Class AbstractResourceProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractResourceProvider
{
    /**
     * @var ResourceInterface
     */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getResource($strict = true)
    {
        if ($strict && !$this->hasResource()) {
            throw new \InvalidArgumentException(sprintf('Resource "%s" has not been set prior to accessing it', get_class($this)));
        }

        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function hasResource()
    {
        return ($this->resource instanceof ResourceInterface);
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceIdentifier()
    {
        if ($this->hasResource()) {
            return $this->resource->getId();
        }

        return null;
    }
}
