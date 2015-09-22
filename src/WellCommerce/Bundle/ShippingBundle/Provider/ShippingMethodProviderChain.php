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

use WellCommerce\Common\Collections\ArrayCollection;

/**
 * Class ShippingMethodProviderChain
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodProviderChain extends ArrayCollection
{
    /**
     * @param ShippingMethodProviderInterface $provider
     */
    public function add(ShippingMethodProviderInterface $provider)
    {
        $this->items[] = $provider;
    }

    /**
     * @return ShippingMethodProviderInterface[]
     */
    public function all()
    {
        return $this->items;
    }

    public function findProvider(){

    }
}
