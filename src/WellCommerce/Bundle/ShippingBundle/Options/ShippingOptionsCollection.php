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

namespace WellCommerce\Bundle\ShippingBundle\Options;

use WellCommerce\Common\Collections\ArrayCollection;

/**
 * Class ShippingOptionsCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingOptionsCollection extends ArrayCollection
{
    /**
     * @param ShippingOptionInterface $shippingOption
     */
    public function add(ShippingOptionInterface $shippingOption)
    {
        $this->items[] = $shippingOption;
    }

    /**
     * @return ShippingOptionInterface[]
     */
    public function all()
    {
        return $this->items;
    }
}
