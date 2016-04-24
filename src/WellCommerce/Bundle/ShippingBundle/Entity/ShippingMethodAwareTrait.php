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

namespace WellCommerce\Bundle\ShippingBundle\Entity;

/**
 * Class ShippingMethodAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ShippingMethodAwareTrait
{
    protected $shippingMethod;

    public function getShippingMethod() : ShippingMethodInterface
    {
        return $this->shippingMethod;
    }

    public function setShippingMethod(ShippingMethodInterface $shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
    }
    
    public function hasShippingMethod() : bool
    {
        return $this->shippingMethod instanceof ShippingMethodInterface;
    }
}
