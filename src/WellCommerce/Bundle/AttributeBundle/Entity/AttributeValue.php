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
 * Class AttributeValue
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValue implements AttributeValueInterface
{
    use IdentifiableTrait;
    use Translatable;
    use Timestampable;
    use Blameable;
    
    /**
     * @var Collection
     */
    protected $attributes;
    
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }
    
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }
    
    public function setAttributes(Collection $attributes)
    {
        $this->syncOldAttributes($attributes);
        $this->syncNewAttributes($attributes);
    }
    
    public function addAttribute(AttributeInterface $attribute)
    {
        $this->attributes->add($attribute);
        $attribute->addValue($this);
    }
    
    private function syncOldAttributes(Collection $attributes)
    {
        $this->attributes->map(function (AttributeInterface $attribute) use ($attributes) {
            if (false === $attributes->contains($attribute)) {
                $attribute->removeValue($this);
            }
        });
    }
    
    private function syncNewAttributes(Collection $attributes)
    {
        $attributes->map(function (AttributeInterface $attribute) {
            if (false === $this->attributes->contains($attribute)) {
                $attribute->addValue($this);
            }
        });
    }
}
