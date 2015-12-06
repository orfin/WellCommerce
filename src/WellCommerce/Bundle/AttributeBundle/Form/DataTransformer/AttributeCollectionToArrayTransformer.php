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
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\Attribute\GroupInterface;
use WellCommerce\Bundle\AttributeBundle\Manager\Admin\AttributeManager;
use WellCommerce\Bundle\AttributeBundle\Manager\Admin\AttributeValueManager;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;

/**
 * Class AttributeCollectionToArrayTransformer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * @var AttributeManager
     */
    protected $attributeManager;

    /**
     * @var AttributeValueManager
     */
    protected $attributeValueManager;

    /**
     * @param AttributeManager $attributeManager
     */
    public function setAttributeManager(AttributeManager $attributeManager)
    {
        $this->attributeManager = $attributeManager;
    }

    /**
     * @param AttributeValueManager $attributeValueManager
     */
    public function setAttributeValueManager(AttributeValueManager $attributeValueManager)
    {
        $this->attributeValueManager = $attributeValueManager;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        $collection = new ArrayCollection();

        if (null === $value || empty($value)) {
            return $collection;
        }

        if ($modelData instanceof GroupInterface) {
            foreach ($value['editor'] as $attribute) {
                $item = $this->findOrCreate($attribute, $modelData);
                $collection->add($item);
            }
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $collection);
    }

    /**
     * {@inheritdoc}
     */
    public function findOrCreate($data, GroupInterface $group)
    {
        $id        = $this->propertyAccessor->getValue($data, '[id]');
        $name      = $this->propertyAccessor->getValue($data, '[name]');
        $values    = $this->propertyAccessor->getValue($data, '[values]');
        $attribute = $this->attributeManager->getAttribute($id, $name, $group);

        if (!empty($values)) {
            $valuesCollection = new ArrayCollection();
            foreach($values as $value){
                $attributeValue = $this->attributeValueManager->getAttributeValue($value['id'], $value['name'], $attribute);
                $valuesCollection->add($attributeValue);
            }

            $attribute->setValues($valuesCollection);
        }

        return $attribute;
    }
}
