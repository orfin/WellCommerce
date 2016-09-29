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
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;

/**
 * Interface AttributeInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeInterface extends
    EntityInterface,
    TimestampableInterface,
    TranslatableInterface,
    BlameableInterface
{
    /**
     * @return Collection
     */
    public function getGroups() : Collection;

    /**
     * @param Collection $groups
     */
    public function setGroups(Collection $groups);

    /**
     * @param AttributeGroupInterface $group
     */
    public function addGroup(AttributeGroupInterface $group);

    /**
     * @return Collection
     */
    public function getValues() : Collection;

    /**
     * @param Collection $collection
     */
    public function setValues(Collection $collection);

    /**
     * @param AttributeValueInterface $value
     */
    public function removeValue(AttributeValueInterface $value);

    /**
     * @param AttributeValueInterface $value
     */
    public function addValue(AttributeValueInterface $value);
}
