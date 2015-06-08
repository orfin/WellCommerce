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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Address
 *
 * @ORM\Embeddable
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Address
{
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $firstName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $lastName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    protected $street;
    
    /**
     * @var string
     *
     * @ORM\Column(name="street_no", type="string", length=255, nullable=true)
     */
    protected $streetNo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="flat_no", type="string", length=255, nullable=true)
     */
    protected $flatNo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="post_code", type="string", length=255, nullable=true)
     */
    protected $postCode;
    
    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=255, nullable=true)
     */
    protected $province;
    
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;
    
    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=3, nullable=true)
     */
    protected $country;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getStreetNo()
    {
        return $this->streetNo;
    }

    /**
     * @param string $streetNo
     */
    public function setStreetNo($streetNo)
    {
        $this->streetNo = $streetNo;
    }

    /**
     * @return string
     */
    public function getFlatNo()
    {
        return $this->flatNo;
    }

    /**
     * @param string $flatNo
     */
    public function setFlatNo($flatNo)
    {
        $this->flatNo = $flatNo;
    }

    /**
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @param string $postCode
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
