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

namespace WellCommerce\Bundle\CompanyBundle\Entity;

/**
 * Class Address
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyAddress implements CompanyAddressInterface
{
    /**
     * @var string
     */
    protected $street;
    
    /**
     * @var string
     */
    protected $streetNo;
    
    /**
     * @var string
     */
    protected $flatNo;
    
    /**
     * @var string
     */
    protected $postCode;
    
    /**
     * @var string
     */
    protected $province;
    
    /**
     * @var string
     */
    protected $city;
    
    /**
     * @var string
     */
    protected $country;

    /**
     * {@inheritdoc}
     */
    public function getStreet() : string
    {
        return $this->street;
    }

    /**
     * {@inheritdoc}
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * {@inheritdoc}
     */
    public function getStreetNo() : string
    {
        return $this->streetNo;
    }

    /**
     * {@inheritdoc}
     */
    public function setStreetNo(string $streetNo)
    {
        $this->streetNo = $streetNo;
    }

    /**
     * {@inheritdoc}
     */
    public function getFlatNo() : string
    {
        return $this->flatNo;
    }

    /**
     * {@inheritdoc}
     */
    public function setFlatNo(string $flatNo)
    {
        $this->flatNo = $flatNo;
    }

    /**
     * {@inheritdoc}
     */
    public function getPostCode() : string
    {
        return $this->postCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setPostCode(string $postCode)
    {
        $this->postCode = $postCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvince() : string
    {
        return $this->province;
    }

    /**
     * {@inheritdoc}
     */
    public function setProvince(string $province)
    {
        $this->province = $province;
    }

    /**
     * {@inheritdoc}
     */
    public function getCity() : string
    {
        return $this->city;
    }

    /**
     * {@inheritdoc}
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry() : string
    {
        return $this->country;
    }

    /**
     * {@inheritdoc}
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }
}
