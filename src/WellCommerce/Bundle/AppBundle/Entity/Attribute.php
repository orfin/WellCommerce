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

namespace WellCommerce\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\AppBundle\Entity\Attribute\GroupInterface;

/**
 * Class Attribute
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Attribute implements AttributeInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var GroupInterface
     */
    protected $attributeGroup;

    /**
     * @var Collection
     */
    protected $values;

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
    public function getAttributeGroup()
    {
        return $this->attributeGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeGroup(GroupInterface $attributeGroup)
    {
        $this->attributeGroup = $attributeGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function setValues(Collection $collection)
    {
        $this->values = $collection;
    }
}
