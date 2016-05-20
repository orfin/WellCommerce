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

namespace WellCommerce\Bundle\ClientBundle\Entity;

/**
 * Class ClientShippingAddressAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ClientShippingAddressAwareTrait
{
    protected $shippingAddress;
    
    public function getShippingAddress() : ClientShippingAddressInterface
    {
        return $this->shippingAddress;
    }
    
    public function setShippingAddress(ClientShippingAddressInterface $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }
    
    public function hasShippingAddress() : bool
    {
        return $this->shippingAddress instanceof ClientShippingAddressInterface;
    }
}
