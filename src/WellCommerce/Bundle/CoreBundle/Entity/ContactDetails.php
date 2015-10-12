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
 * Class ContactDetails
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactDetails implements ContactDetailsInterface
{
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
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getSecondaryPhone()
    {
        return $this->secondaryPhone;
    }

    /**
     * @param string $secondaryPhone
     */
    public function setSecondaryPhone($secondaryPhone)
    {
        $this->secondaryPhone = $secondaryPhone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
