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

use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroup;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface AttributeRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns all groups with translations
     *
     * @return array
     */
    public function findAll();

    /**
     * Returns all attributes by group id
     *
     * @param integer $id Attribute group id
     *
     * @return mixed
     */
    public function findAllByAttributeGroupId($id);
}
