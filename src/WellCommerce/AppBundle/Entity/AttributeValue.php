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

namespace WellCommerce\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * Class AttributeValue
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValue implements AttributeValueInterface
{
    use Translatable, Timestampable, Blameable;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var AttributeInterface
     */
    protected $attribute;

    /**
     * @var Collection
     */
    protected $productAttributeValues;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute()
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
    public function getProductAttributeValues()
    {
        return $this->productAttributeValues;
    }

    /**
     * {@inheritdoc}
     */
    public function setProductAttributeValues(Collection $productAttributeValues)
    {
        $this->productAttributeValues = $productAttributeValues;
    }
}
