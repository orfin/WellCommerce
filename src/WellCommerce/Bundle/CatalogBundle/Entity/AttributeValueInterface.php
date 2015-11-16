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

namespace WellCommerce\Bundle\CatalogBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface AttributeValueInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeValueInterface extends TranslatableInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return AttributeInterface
     */
    public function getAttribute();

    /**
     * @param AttributeInterface $attribute
     */
    public function setAttribute(AttributeInterface $attribute);

    /**
     * @return Collection
     */
    public function getProductAttributeValues();

    /**
     * @param Collection $productAttributeValues
     */
    public function setProductAttributeValues(Collection $productAttributeValues);
}
