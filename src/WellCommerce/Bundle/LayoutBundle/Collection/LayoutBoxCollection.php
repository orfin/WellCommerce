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

namespace WellCommerce\Bundle\LayoutBundle\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox;

/**
 * Class LayoutBoxCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxCollection extends AbstractCollection
{
    /**
     * Constructor
     *
     * @param ArrayCollection $collection
     */
    public function __construct($collection)
    {
        foreach ($collection as $box) {
            $this->add($box);
        }
    }

    public function add(LayoutBox $box)
    {
        $this->items[$box->getIdentifier()] = $box;
    }
} 