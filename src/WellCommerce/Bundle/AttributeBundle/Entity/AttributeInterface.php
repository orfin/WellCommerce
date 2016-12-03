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
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface AttributeInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeInterface extends EntityInterface, TimestampableInterface, TranslatableInterface, BlameableInterface
{
    public function getGroups(): Collection;
    
    public function setGroups(Collection $groups);
    
    public function addGroup(AttributeGroupInterface $group);
    
    public function getValues(): Collection;
    
    public function setValues(Collection $collection);
    
    public function removeValue(AttributeValueInterface $value);
    
    public function addValue(AttributeValueInterface $value);
}
