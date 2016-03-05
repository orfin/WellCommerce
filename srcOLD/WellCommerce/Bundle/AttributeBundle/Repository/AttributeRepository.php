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
namespace WellCommerce\Bundle\AttributeBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\AbstractEntityRepository;

/**
 * Class AttributeRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeRepository extends AbstractEntityRepository implements AttributeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCollectionByAttributeGroup(AttributeGroupInterface $attributeGroup)
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->eq('attributeGroup', $attributeGroup));

        return $this->matching($criteria);
    }

    public function getAttributesWithValues()
    {
        $attributes = [];
        $collection = $this->matching(new Criteria());
        $collection->map(function (AttributeInterface $attribute) use (&$attributes) {
            $attributes[] = [
                'id'     => $attribute->getId(),
                'name'   => $attribute->translate()->getName(),
                'values' => $this->getAttributeValues($attribute->getValues())
            ];
        });

        return $attributes;
    }

    protected function getAttributeValues(Collection $collection)
    {
        $values = [];
        $collection->map(function (AttributeValueInterface $value) use (&$values) {
            $values[] = [
                'id'   => $value->getId(),
                'name' => $value->translate()->getName()
            ];
        });

        return $values;
    }
}
