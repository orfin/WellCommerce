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

namespace WellCommerce\Bundle\CoreBundle\Entity;

/**
 * Class AddressTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait AddressTrait
{
    private $line1;
    private $line2;
    private $postalCode;
    private $state;
    private $city;
    private $country;
    
    public function getLine1() : string
    {
        return $this->line1;
    }
    
    public function setLine1(string $line1)
    {
        $this->line1 = $line1;
    }
    
    public function getLine2() : string
    {
        return $this->line2;
    }
    
    public function setLine2(string $line2)
    {
        $this->line2 = $line2;
    }
    
    public function getPostalCode() : string
    {
        return $this->postalCode;
    }
    
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }
    
    public function getState() : string
    {
        return $this->state;
    }
    
    public function setState(string $state)
    {
        $this->state = $state;
    }
    
    public function getCity() : string
    {
        return $this->city;
    }
    
    public function setCity(string $city)
    {
        $this->city = $city;
    }
    
    public function getCountry() : string
    {
        return $this->country;
    }
    
    public function setCountry(string $country)
    {
        $this->country = $country;
    }
}
