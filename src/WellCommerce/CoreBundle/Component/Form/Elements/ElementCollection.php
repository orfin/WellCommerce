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

namespace WellCommerce\CoreBundle\Component\Form\Elements;

use WellCommerce\CoreBundle\Component\Collection\ArrayCollection;

/**
 * Class ElementCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ElementCollection extends ArrayCollection
{
    /**
     * Adds new element to collection
     *
     * @param ElementInterface $element
     */
    public function add(ElementInterface $element)
    {
        $this->items[$element->getName()] = $element;
    }
}
