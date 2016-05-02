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
 * Interface ClientAddressInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientAddressInterface
{
    public function getFirstName() : string;
    
    public function setFirstName(string $firstName);
    
    public function getLastName() : string;
    
    public function setLastName(string $lastName);
    
    public function getLine1() : string;
    
    public function setLine1(string $line1);
    
    public function getLine2() : string;
    
    public function setLine2(string $line2);
    
    public function getPostalCode() : string;
    
    public function setPostalCode(string $postalCode);
    
    public function getState() : string;
    
    public function setState(string $state);
    
    public function getCity() : string;
    
    public function setCity(string $city);
    
    public function getCountry() : string;
    
    public function setCountry(string $country);
}
