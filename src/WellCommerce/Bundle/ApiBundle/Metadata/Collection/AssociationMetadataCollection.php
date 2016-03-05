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

use WellCommerce\Bundle\ApiBundle\Metadata\AssociationMetadataInterface;
use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class AssociationMetadataCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AssociationMetadataCollection extends ArrayCollection
{
    /**
     * Adds new association metadata to collection
     *
     * @param AssociationMetadataInterface $metadata
     */
    public function add(AssociationMetadataInterface $metadata)
    {
        $this->items[$metadata->getName()] = $metadata;
    }

    /**
     * Returns all metadata entries
     *
     * @return AssociationMetadataInterface[]
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Returns the metadata for field or throw an exception if metadata was not found
     *
     * @param string $associationName
     *
     * @return AssociationMetadataInterface
     * @throws \InvalidArgumentException
     */
    public function get($associationName)
    {
        if (!$this->has($associationName)) {
            throw new \InvalidArgumentException(sprintf('Metadata for association "%s" does not exists', $associationName));
        }

        return $this->items[$associationName];
    }
}
