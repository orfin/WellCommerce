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
     * @var \WellCommerce\Bundle\AttributeBundle\Repository\AttributeRepositoryInterface
     */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        $collection = new ArrayCollection();
        if (null == $value || empty($value)) {
            return $collection;
        }
        foreach ($value['editor'] as $attribute) {
            $item = $this->repository->findOrCreate($attribute);
            $collection->add($item);
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $collection);
    }
}
