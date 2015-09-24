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

namespace WellCommerce\Bundle\AttributeBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * Class Attribute
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Attribute implements AttributeInterface
{
    use Translatable, Timestampable, Blameable;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Collection
     */
    protected $groups;

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
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
    public function setGroups(Collection $collection)
    {
        $this->groups = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function addGroup(AttributeGroupInterface $group)
    {
        $group->addAttribute($this);
        $this->groups[] = $group;
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
        foreach ($this->values as $value) {
            if (!$collection->contains($value)) {
                $this->values->removeElement($value);
            }
        }

        $this->values = $collection;
    }
}
