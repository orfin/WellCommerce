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
 * Interface ShippingMethodAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodAwareInterface
{
    public function setShippingMethod(ShippingMethodInterface $shippingMethod = null);
    
    /**
     * @return null|ShippingMethodInterface
     */
    public function getShippingMethod();
    
    public function hasShippingMethod() : bool;
}
