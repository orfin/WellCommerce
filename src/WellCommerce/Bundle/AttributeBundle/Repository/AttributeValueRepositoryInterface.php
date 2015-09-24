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

namespace WellCommerce\Bundle\AttributeBundle\Repository;

use WellCommerce\Bundle\AttributeBundle\Entity\Attribute;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface AttributeValueRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeValueRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns all values (with translations) for given attribute
     *
     * @return array
     */
    public function findAllByAttributeId($id);

    /**
     * Makes a collection of attribute values
     *
     * @param Attribute $attribute
     * @param           $values
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function makeCollection(Attribute $attribute, $values);
}
