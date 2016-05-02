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
 * Interface ClientShippingAddressAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientShippingAddressAwareInterface
{
    public function getShippingAddress() : ClientShippingAddressInterface;
    
    public function setShippingAddress(ClientShippingAddressInterface $shippingAddress);
    
    public function hasShippingAddress() : bool;
}
