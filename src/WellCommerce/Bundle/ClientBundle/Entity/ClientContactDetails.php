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
    /**
     * @var string
     */
    protected $firstName;
    
    /**
     * @var string
     */
    protected $lastName;
    
    /**
     * @var string
     */
    protected $phone;
    
    /**
     * @var string
     */
    protected $secondaryPhone;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSecondaryPhone()
    {
        return $this->secondaryPhone;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSecondaryPhone($secondaryPhone)
    {
        $this->secondaryPhone = $secondaryPhone;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
