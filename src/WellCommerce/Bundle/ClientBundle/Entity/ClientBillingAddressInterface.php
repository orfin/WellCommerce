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
 * Interface ClientBillingAddressInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientBillingAddressInterface extends ClientAddressInterface
{
    public function setVatId(string $vatId);
    
    public function getVatId() : string;
    
    public function setCompanyName(string $companyName);
    
    public function getCompanyName() : string;
    
    public function isCompanyAddress() : bool;
    
    public function setCompanyAddress(bool $companyAddress);
}
