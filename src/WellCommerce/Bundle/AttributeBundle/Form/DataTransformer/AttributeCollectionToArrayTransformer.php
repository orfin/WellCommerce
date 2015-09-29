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

namespace WellCommerce\Bundle\AttributeBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;

/**
 * Class AttributeCollectionToArrayTransformer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        $collection = new ArrayCollection();

        if (null === $value || empty($value)) {
            return $collection;
        }
        foreach ($value['editor'] as $attribute) {
            $item = $this->findOrCreate($attribute);
            $collection->add($item);
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $collection);
    }

    /**
     * {@inheritdoc}
     */
    public function findOrCreate($data)
    {
        $id       = $this->propertyAccessor->getValue($data, '[id]');
        $name     = $this->propertyAccessor->getValue($data, '[name]');
        $values   = $this->propertyAccessor->getValue($data, '[values]');
        $isNew    = substr($id, 0, 3) == 'new';

        if ($isNew) {
            $item = $this->addAttribute($name);
        } else {
            $item = $this->find($id);
        }

        if (!empty($values)) {
            $collection = $this->getAttributeValueRepository()->makeCollection($item, $values);
            $item->setValues($collection);
        }

        return $item;
    }
}
