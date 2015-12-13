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

namespace WellCommerce\Bundle\AppBundle\Doctrine\ORM\Behaviours;

/**
 * Class AddressTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait AddressTrait
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
