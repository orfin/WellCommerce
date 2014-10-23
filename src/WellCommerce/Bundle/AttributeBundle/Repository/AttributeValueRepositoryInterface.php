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
 * @package WellCommerce\Bundle\AttributeBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeValueRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns all groups with translations
     *
     * @return array
     */
    public function findAll();

    /**
     * Returns all values (with translations) for given attribute
     *
     * @return array
     */
    public function findAllByAttributeId($id);

    /**
     * Adds new attribute value and binds it to attribute
     *
     * @param Attribute $attribute
     * @param           $name
     *
     * @return mixed
     */
    public function addAttributeValue(Attribute $attribute, $name);

    /**
     * Makes a collection of attribute values
     *
     * @param Attribute $attribute
     * @param           $values
     *
     * @return mixed
     */
    public function makeCollection(Attribute $attribute, $values);
} 