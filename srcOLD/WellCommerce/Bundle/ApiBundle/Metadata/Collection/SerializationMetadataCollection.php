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

namespace WellCommerce\Bundle\ApiBundle\Metadata\Collection;

use WellCommerce\Bundle\ApiBundle\Metadata\SerializationClassMetadataInterface;
use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class SerializationMetadataCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SerializationMetadataCollection extends ArrayCollection
{
    /**
     * Adds new metadata to collection
     *
     * @param SerializationClassMetadataInterface $metadata
     */
    public function add(SerializationClassMetadataInterface $metadata)
    {
        $this->items[$metadata->getClass()] = $metadata;
    }

    /**
     * Returns all metadata entries
     *
     * @return SerializationClassMetadataInterface[]
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Returns the metadata for class or throw an exception if metadata was not found
     *
     * @param string $class
     *
     * @return SerializationClassMetadataInterface
     * @throws \InvalidArgumentException
     */
    public function get($class)
    {
        if (!$this->has($class)) {
            throw new \InvalidArgumentException(sprintf('Serialization metadata for class %s does not exists', $class));
        }

        return $this->items[$class];
    }
}
