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

namespace WellCommerce\Bundle\AttributeBundle\Manager\Admin;

use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class AttributeManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeManager extends AbstractAdminManager
{
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

    protected function findAttributeGroup(int $id) : AttributeGroupInterface
    {
        return $this->get('attribute_group.repository')->find($id);
    }

    protected function getAttributeValuesSet(AttributeInterface $attribute) : array
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
