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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class Attribute
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Attribute implements AttributeInterface
{
    use IdentifiableTrait;
    use Translatable;
    use Timestampable;
    use Blameable;
    
    /**
     * @var Collection
     */
    protected $groups;
    
    /**
     * @var Collection
     */
    protected $values;
    
    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->values = new ArrayCollection();
    }
    
    public function getGroups() : Collection
    {
        return $this->groups;
    }
    
    public function setGroups(Collection $groups)
    {
        $this->groups->map(function (AttributeGroupInterface $group) use ($groups) {
            if (false === $groups->contains($group)) {
                $group->removeAttribute($this);
            }
        });
        
        $groups->map(function (AttributeGroupInterface $group) {
            if (false === $this->groups->contains($group)) {
                $group->addAttribute($this);
            }
        });
    }
    
    public function addGroup(AttributeGroupInterface $group)
    {
        $this->groups->add($group);
        $group->addAttribute($this);
    }
    
    public function getValues() : Collection
    {
        return $this->values;
    }
    
    public function setValues(Collection $collection)
    {
        $this->values = $collection;
    }
    
    public function removeValue(AttributeValueInterface $value)
    {
        $this->values->removeElement($value);
    }
    
    public function addValue(AttributeValueInterface $value)
    {
        $this->values->add($value);
    }
}
