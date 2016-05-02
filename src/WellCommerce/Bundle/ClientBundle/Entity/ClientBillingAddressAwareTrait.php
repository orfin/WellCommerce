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
 * Class ClientBillingAddressAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ClientBillingAddressAwareTrait
{
    private $billingAddress;
    
    public function getBillingAddress() : ClientBillingAddressInterface
    {
        return $this->billingAddress;
    }
    
    public function setBillingAddress(ClientBillingAddressInterface $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }
    
    public function hasBillingAddress() : bool
    {
        return $this->billingAddress instanceof ClientBillingAddressInterface;
    }
}
