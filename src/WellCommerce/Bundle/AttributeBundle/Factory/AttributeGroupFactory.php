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

namespace WellCommerce\Bundle\AttributeBundle\Factory;

use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroup;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class AttributeGroupFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupFactory extends AbstractEntityFactory
{
    public function create() : AttributeGroupInterface
    {
        $group = new AttributeGroup();
        $group->setAttributes($this->createEmptyCollection());

        return $group;
    }
}
