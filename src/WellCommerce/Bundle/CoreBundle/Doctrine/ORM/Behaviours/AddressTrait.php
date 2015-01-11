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

namespace WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours;

/**
 * Class AddressTrait
 *
 * @package WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait AddressTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="street_no", type="string", length=255, nullable=true)
     */
    private $streetNo;

    /**
     * @var string
     *
     * @ORM\Column(name="flat_no", type="string", length=255, nullable=true)
     */
    private $flatNo;

    /**
     * @var string
     *
     * @ORM\Column(name="post_code", type="string", length=255, nullable=true)
     */
    private $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=255, nullable=true)
     */
    private $province;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=3, nullable=true)
     */
    private $country;

    /**
     * Get street.
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set street.
     *
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get streetNo.
     *
     * @return string
     */
    public function getStreetNo()
    {
        return $this->streetNo;
    }

    /**
     * Set streetNo.
     *
     * @param string $streetNo
     */
    public function setStreetNo($streetNo)
    {
        $this->streetNo = $streetNo;
    }

    /**
     * Get flatNo.
     *
     * @return string
     */
    public function getFlatNo()
    {
        return $this->flatNo;
    }

    /**
     * Set flatNo.
     *
     * @param string $flatNo
     */
    public function setFlatNo($flatNo)
    {
        $this->flatNo = $flatNo;
    }

    /**
     * Get postCode.
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set postCode.
     *
     * @param string $postCode
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city.
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get province.
     *
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set province.
     *
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country.
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
} 