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

use WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;

/**
 * Class AttributeFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeFactory extends EntityFactory
{
    public function create() : AttributeInterface
    {
        /** @var $attribute AttributeInterface */
        $attribute = $this->init();
        $attribute->setValues($this->createEmptyCollection());
        $attribute->setGroups($this->createEmptyCollection());

        return $attribute;
    }

}
