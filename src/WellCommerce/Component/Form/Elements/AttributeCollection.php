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

namespace WellCommerce\Component\Form\Elements;

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class AttributeCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeCollection extends ArrayCollection
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
