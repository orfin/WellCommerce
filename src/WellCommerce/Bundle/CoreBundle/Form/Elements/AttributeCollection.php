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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class AttributeCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeCollection extends AbstractCollection
{
    /**
     * Adds new element attribute to collection
     *
     * @param Attribute $attribute
     */
    public function add(Attribute $attribute)
    {
        $this->items[$attribute->getName()] = $attribute;
    }
}
