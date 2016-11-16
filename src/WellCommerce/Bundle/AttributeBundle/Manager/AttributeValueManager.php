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

use WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;

/**
 * Class AttributeValueManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueManager extends AbstractManager
{
    public function addAttributeValue(string $attributeValueName, int $attributeId) : AttributeValueInterface
    {
        $attribute = $this->findAttribute($attributeId);
        $value     = $this->createAttributeValue($attributeValueName, $attribute);

        return $value;
    }

    protected function findAttribute(int $attributeId) : AttributeInterface
    {
        return $this->get('attribute.repository')->find($attributeId);
    }

    protected function createAttributeValue(string $name, AttributeInterface $attribute) : AttributeValueInterface
    {
        /** @var $value AttributeValueInterface */
        $value = $this->initResource();

        foreach ($this->getLocales() as $locale) {
            $value->translate($locale->getCode())->setName($name);
        }

        $value->mergeNewTranslations();
        $value->addAttribute($attribute);
        $this->createResource($value);

        return $value;
    }
}
