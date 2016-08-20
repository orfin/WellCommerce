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

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;

/**
 * Class AttributeRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeRepository extends EntityRepository implements AttributeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('attribute.id');
        $queryBuilder->leftJoin('attribute.translations', 'attribute_translation');
        $queryBuilder->leftJoin('attribute.groups', 'attribute_groups');
        $queryBuilder->leftJoin('attribute_groups.translations', 'attribute_groups_translation');

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeSet(AttributeGroupInterface $attributeGroup) : array
    {
        $sets                 = [];
        $attributesCollection = $attributeGroup->getAttributes();
        
        $attributesCollection->map(function (AttributeInterface $attribute) use (&$sets) {
            $sets[] = [
                'id'     => $attribute->getId(),
                'name'   => $attribute->translate()->getName(),
                'values' => $this->getAttributeValuesSet($attribute)
            ];
        });
        
        return $sets;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeValuesSet(AttributeInterface $attribute) : array
    {
        $values                    = [];
        $attributeValuesCollection = $attribute->getValues();

        $attributeValuesCollection->map(function (AttributeValueInterface $attributeValue) use (&$values) {
            $values[] = [
                'id'   => $attributeValue->getId(),
                'name' => $attributeValue->translate()->getName()
            ];
        });

        return $values;
    }
}
