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

namespace WellCommerce\Bundle\ShippingBundle\Provider;

use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Common\Collections\ArrayCollection;

/**
 * Class ShippingMethodCostCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodCostCollection extends ArrayCollection
{
    /**
     * @param ShippingMethodCostInterface $shippingOption
     */
    public function add(ShippingMethodCostInterface $shippingMethodCost)
    {
        $this->items[] = $shippingMethodCost;
    }

    /**
     * @return ShippingMethodCostInterface[]
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @return ShippingMethodCostInterface
     */
    public function first()
    {
        return reset($this->items);
    }
}
