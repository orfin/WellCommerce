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

namespace WellCommerce\CommonBundle\Entity;

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
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * {@inheritdoc}
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * {@inheritdoc}
     */
    public function getStreetNo()
    {
        return $this->streetNo;
    }

    /**
     * {@inheritdoc}
     */
    public function setStreetNo($streetNo)
    {
        $this->streetNo = $streetNo;
    }

    /**
     * {@inheritdoc}
     */
    public function getFlatNo()
    {
        return $this->flatNo;
    }

    /**
     * {@inheritdoc}
     */
    public function setFlatNo($flatNo)
    {
        $this->flatNo = $flatNo;
    }

    /**
     * {@inheritdoc}
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * {@inheritdoc}
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * {@inheritdoc}
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * {@inheritdoc}
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
