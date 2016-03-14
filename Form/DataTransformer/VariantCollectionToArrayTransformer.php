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
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;
use WellCommerce\Bundle\ProductBundle\Manager\Admin\VariantManager;

/**
 * Class VariantCollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class VariantCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * @var VariantManager
     */
    protected $variantManager;

    /**
     * @param VariantManager $variantManager
     */
    public function setVariantManager(VariantManager $variantManager)
    {
        $this->variantManager = $variantManager;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        $values = [];

        if ($modelData instanceof Collection) {
            $modelData->map(function (VariantInterface $variant) use (&$values) {
                $values[] = [
                    'id'           => $variant->getId(),
                    'suffix'       => $variant->getModifierType(),
                    'modifier'     => $variant->getModifierValue(),
                    'stock'        => $variant->getStock(),
                    'symbol'       => $variant->getSymbol(),
                    'weight'       => $variant->getWeight(),
                    'availability' => $this->transformAvailability($variant->getAvailability()),
                    'attributes'   => $this->transformValues($variant->getAttributeValues()),
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
            $collection = $this->variantManager->getAttributesCollectionForProduct($modelData, $values);
            $modelData->setAttributes($collection);
        }
    }
}
