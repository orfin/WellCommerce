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
    /**
     * @return string
     */
    public function getFirstName();
    
    /**
     * @param string $firstName
     */
    public function setFirstName($firstName);
    
    /**
     * @return string
     */
    public function getLastName();
    
    /**
     * @param string $lastName
     */
    public function setLastName($lastName);
    
    /**
     * @return string
     */
    public function getPhone();
    
    /**
     * @param string $phone
     */
    public function setPhone($phone);
    
    /**
     * @return string
     */
    public function getSecondaryPhone();
    
    /**
     * @param string $secondaryPhone
     */
    public function setSecondaryPhone($secondaryPhone);
    
    /**
     * @return string
     */
    public function getEmail();
    
    /**
     * @param string $email
     */
    public function setEmail($email);
}
