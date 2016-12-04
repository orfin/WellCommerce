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
 * Class ClientContactDetails
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientContactDetails implements ClientContactDetailsInterface
{
    protected $firstName      = '';
    protected $lastName       = '';
    protected $phone          = '';
    protected $secondaryPhone = '';
    protected $email          = '';
    
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }
    
    public function getLastName(): string
    {
        return $this->lastName;
    }
    
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
    
    public function getPhone(): string
    {
        return $this->phone;
    }
    
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }
    
    public function getSecondaryPhone(): string
    {
        return $this->secondaryPhone;
    }
    
    public function setSecondaryPhone(string $secondaryPhone)
    {
        $this->secondaryPhone = $secondaryPhone;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
}
