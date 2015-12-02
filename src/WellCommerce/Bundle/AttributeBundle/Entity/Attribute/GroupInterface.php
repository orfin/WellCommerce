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

namespace WellCommerce\Bundle\AttributeBundle\Entity\Attribute;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface GroupInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface GroupInterface extends TimestampableInterface, TranslatableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return Collection
     */
    public function getAttributes();

    /**
     * @param Collection $collection
     */
    public function setAttributes(Collection $collection);

    /**
     * @param AttributeInterface $attribute
     */
    public function addAttribute(AttributeInterface $attribute);
}
