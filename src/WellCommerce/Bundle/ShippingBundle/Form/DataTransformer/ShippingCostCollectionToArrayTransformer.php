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

namespace WellCommerce\Bundle\ShippingBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCost;

/**
 * Class ShippingCostCollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingCostCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        if (null === $modelData || !$modelData instanceof PersistentCollection) {
            return [];
        }

        $items = [];
        foreach ($modelData as $item) {
            $items['ranges'][] = $this->getRangeData($item);
        }

        return $items;
    }

    /**
     * Returns costs data as an array
     *
     * @param ShippingMethodCost $cost
     *
     * @return array
     */
    private function getRangeData(ShippingMethodCost $cost)
    {
        return [
            'min'   => $cost->getRangeFrom(),
            'max'   => $cost->getRangeTo(),
            'price' => $cost->getCost()->getGrossAmount(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        $newCollection = $this->prepareCostsCollection($value, $modelData);
        $oldCollection = $this->propertyAccessor->getValue($modelData, $propertyPath);

        foreach ($oldCollection as $oldEntity) {
            $modelData->getCosts()->removeElement($oldEntity);
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $newCollection);
    }

    private function prepareCostsCollection(array $values, ShippingMethod $shippingMethod)
    {
        if (!isset($values['ranges'])) {
            throw new \InvalidArgumentException('Wrong arguments passed. Ranges are missing in the "costs" array.');
        }

        $collection = new ArrayCollection();

        foreach ($values['ranges'] as $value) {
            $cost = new Price();
            $cost->setGrossAmount($value['price']);
            $range = new ShippingMethodCost();
            $range->setCost($cost);
            $range->setRangeFrom($value['min']);
            $range->setRangeTo($value['max']);
            $range->setShippingMethod($shippingMethod);
            $collection->add($range);
        }

        return $collection;
    }
}
