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

namespace WellCommerce\Bundle\ProductBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;

/**
 * Class ProductAttributeCollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttributeCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        $items = [];

        if ($modelData instanceof PersistentCollection) {
            foreach ($modelData as $item) {
                $items[] = $this->convertItemToArray($item);
            }
        }

        return $items;
    }

    /**
     * Converts collection item to array representation
     *
     * @param ProductAttribute $item
     *
     * @return array
     */
    protected function convertItemToArray(ProductAttribute $item)
    {
        return [
            'id'           => $item->getId(),
            'suffix'       => $item->getModifierType(),
            'modifier'     => $item->getModifierValue(),
            'stock'        => $item->getStock(),
            'symbol'       => $item->getSymbol(),
            'weight'       => $item->getWeight(),
            'deletable'    => true,
            'availability' => $this->transformAvailability($item->getAvailability()),
            'attributes'   => $this->transformValues($item->getAttributeValues()),
        ];
    }

    /**
     * Transforms availability identifier into entity
     *
     * @param $entity
     *
     * @return int
     */
    private function transformAvailability($entity)
    {
        if (null == $entity) {
            return 0;
        }
        $meta       = $this->getRepository()->getMetadata();
        $identifier = $meta->getSingleIdentifierFieldName();

        return $this->propertyAccessor->getValue($entity, $identifier);
    }

    /**
     * Transforms values collection to identifiers
     *
     * @param PersistentCollection $collection
     *
     * @return array
     */
    public function transformValues(PersistentCollection $collection)
    {
        if (null == $collection) {
            return [];
        }

        $values = [];
        foreach ($collection as $item) {
            $values[$item->getAttribute()->getId()] = $item->getId();
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $values)
    {
        $collection = new ArrayCollection();
        if (null == $modelData || empty($values)) {
            return $collection;
        }
        foreach ($values as $id => $value) {
            if (is_array($value)) {
                $item = $this->getRepository()->findOrCreate($id, $value);
                $collection->add($item);
            }
        }

        $this->propertyAccessor->setValue($entity, $propertyPath, $collection);
    }
}