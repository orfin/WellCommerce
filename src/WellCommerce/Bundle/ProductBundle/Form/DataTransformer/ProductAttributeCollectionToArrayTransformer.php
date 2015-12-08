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

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\ProductBundle\Manager\Admin\ProductAttributeManager;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class ProductAttributeCollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttributeCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * @var ProductAttributeManager
     */
    protected $productAttributeManager;

    /**
     * @param ProductAttributeManager $productAttributeManager
     */
    public function setProductAttributeManager(ProductAttributeManager $productAttributeManager)
    {
        $this->productAttributeManager = $productAttributeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        $values = [];

        if ($modelData instanceof Collection) {
            $modelData->map(function (ProductAttributeInterface $productAttribute) use (&$values) {
                $values[] = [
                    'id'           => $productAttribute->getId(),
                    'suffix'       => $productAttribute->getModifierType(),
                    'modifier'     => $productAttribute->getModifierValue(),
                    'stock'        => $productAttribute->getStock(),
                    'symbol'       => $productAttribute->getSymbol(),
                    'weight'       => $productAttribute->getWeight(),
                    'availability' => $this->transformAvailability($productAttribute->getAvailability()),
                    'attributes'   => $this->transformValues($productAttribute->getAttributeValues()),
                ];
            });
        }

        return $values;
    }

    private function transformAvailability(AvailabilityInterface $availability = null)
    {
        if (null !== $availability) {
            return $availability->getId();
        }

        return null;
    }

    /**
     * Transforms values collection to identifiers
     *
     * @param PersistentCollection $collection
     *
     * @return array
     */
    public function transformValues(Collection $collection = null)
    {
        if (null === $collection) {
            return [];
        }

        $values = [];
        $collection->map(function (AttributeValueInterface $attributeValue) use (&$values) {
            $values[$attributeValue->getAttribute()->getId()] = $attributeValue->getId();
        });

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $values)
    {
        if ($modelData instanceof ProductInterface) {
            $collection = $this->productAttributeManager->getAttributesCollectionForProduct($modelData, $values);
            $modelData->setAttributes($collection);
        }
    }
}
