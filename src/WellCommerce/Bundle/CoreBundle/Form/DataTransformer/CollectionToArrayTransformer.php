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

namespace WellCommerce\Bundle\CoreBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;

/**
 * Class CollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CollectionToArrayTransformer extends AbstractDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        $items      = [];
        $meta       = $this->getRepository()->getMetaData();
        $identifier = $meta->getSingleIdentifierFieldName();

        if ($modelData instanceof Collection) {
            foreach ($modelData as $item) {
                $items[] = $this->propertyAccessor->getValue($item, $identifier);
            }
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        $collection = new ArrayCollection();

        foreach ($value as $key => $val) {
            if (is_int($key)) {
                $item = $this->getRepository()->find($val);
                $collection->add($item);
            }
        }

        $previousCollection = $this->propertyAccessor->getValue($modelData, $propertyPath);
        $this->synchronizeCollection($previousCollection, $collection);
        $this->propertyAccessor->setValue($modelData, $propertyPath, $collection);
    }

    /**
     * Removes all elements from old collection which have not been passed in new collection
     *
     * @param Collection $oldEntities
     * @param Collection $newEntities
     */
    protected function synchronizeCollection(Collection $oldCollection, Collection $newCollection)
    {
        foreach ($oldCollection as $oldEntity) {
            if (!$newCollection->contains($oldEntity)) {
                $newCollection->removeElement($oldEntity);
            }
        }
    }
}
