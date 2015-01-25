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
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;

/**
 * Class CollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CollectionToArrayTransformer extends AbstractDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        $items      = [];
        $meta       = $this->getRepository()->getMetadata();
        $identifier = $meta->getSingleIdentifierFieldName();

        if ($modelData instanceof PersistentCollection) {
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

        if (empty($value)) {
            return $collection;
        }

        foreach ($value as $id) {
            $item = $this->getRepository()->find($id);
            $collection->add($item);
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $collection);
    }
}
