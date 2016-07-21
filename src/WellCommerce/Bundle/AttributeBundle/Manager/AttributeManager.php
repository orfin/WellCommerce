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

namespace WellCommerce\Bundle\AttributeBundle\Manager;

use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\AbstractManager;

/**
 * Class AttributeManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeManager extends AbstractManager
{
    public function createAttribute(string $attributeName, int $attributeGroupId) : AttributeInterface
    {
        /** @var $attribute AttributeInterface */
        $attribute = $this->initResource();
        $group     = $this->findAttributeGroup($attributeGroupId);
        foreach ($this->getLocales() as $locale) {
            $attribute->translate($locale->getCode())->setName($attributeName);
        }
        $attribute->addGroup($group);
        $attribute->mergeNewTranslations();
        $this->saveResource($attribute);

        return $attribute;
    }

    public function getAttributeSet(int $attributeGroupId) : array
    {
        $sets                 = [];
        $attributeGroup       = $this->findAttributeGroup($attributeGroupId);
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

    public function findAttributeGroup(int $id) : AttributeGroupInterface
    {
        return $this->get('attribute_group.repository')->find($id);
    }
}
