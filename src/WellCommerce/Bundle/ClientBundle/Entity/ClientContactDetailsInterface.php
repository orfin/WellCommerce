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
 * Interface ClientContactDetailsInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientContactDetailsInterface
{
    public function getFirstName(): string;
    
    public function setFirstName(string $firstName);
    
    public function getLastName(): string;
    
    public function setLastName(string $lastName);
    
    public function getPhone(): string;
    
    public function setPhone(string $phone);
    
    public function getSecondaryPhone(): string;
    
    public function setSecondaryPhone(string $secondaryPhone);
    
    public function getEmail(): string;
    
    public function setEmail(string $email);
}
