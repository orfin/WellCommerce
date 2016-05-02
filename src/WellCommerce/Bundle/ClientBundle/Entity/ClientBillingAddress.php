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

use WellCommerce\Bundle\CoreBundle\Entity\AddressTrait;

/**
 * Class ClientBillingAddress
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientBillingAddress implements ClientBillingAddressInterface
{
    use AddressTrait;
    
    private $firstName;
    private $lastName;
    private $vatId;
    private $companyName;
    private $companyAddress;
    
    public function getFirstName() : string
    {
        return $this->firstName;
    }
    
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }
    
    public function getLastName() : string
    {
        return $this->lastName;
    }
    
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
    
    public function getVatId() : string
    {
        return $this->vatId;
    }
    
    public function setVatId(string $vatId)
    {
        $this->vatId = $vatId;
    }
    
    public function getCompanyName() : string
    {
        return $this->companyName;
    }
    
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
    }
    
    public function isCompanyAddress() : bool
    {
        return $this->companyAddress;
    }
    
    public function setCompanyAddress(bool $companyAddress)
    {
        $this->companyAddress = $companyAddress;
    }
}
