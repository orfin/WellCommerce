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

namespace WellCommerce\Bundle\ProductBundle\Entity;

use WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class VariantOption
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class VariantOption extends AbstractEntity implements VariantOptionInterface
{
    /**
     * @var VariantInterface
     */
    protected $variant;

    /**
     * @var AttributeInterface
     */
    protected $attribute;

    /**
     * @var AttributeValueInterface
     */
    protected $attributeValue;

    /**
     * {@inheritdoc}
     */
    public function getVariant() : VariantInterface
    {
        return $this->variant;
    }

    /**
     * {@inheritdoc}
     */
    public function setVariant(VariantInterface $variant)
    {
        $this->variant = $variant;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute() : AttributeInterface
    {
        return $this->attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttribute(AttributeInterface $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeValue() : AttributeValueInterface
    {
        return $this->attributeValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeValue(AttributeValueInterface $attributeValue)
    {
        $this->attributeValue = $attributeValue;
    }
}
