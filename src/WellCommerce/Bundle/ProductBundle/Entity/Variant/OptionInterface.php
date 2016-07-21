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

namespace WellCommerce\Bundle\ProductBundle\Entity\Variant;

use WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Interface VariantInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OptionInterface extends EntityInterface
{
    public function getVariant() : VariantInterface;

    public function setVariant(VariantInterface $variant);

    public function getAttribute() : AttributeInterface;

    public function setAttribute(AttributeInterface $attribute);

    public function getAttributeValue() : AttributeValueInterface;

    public function setAttributeValue(AttributeValueInterface $attributeValue);
}
