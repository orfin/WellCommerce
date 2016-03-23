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
 * Interface CompanyAddressInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CompanyAddressInterface
{
    /**
     * @return string
     */
    public function getStreet() : string;

    /**
     * @param string $street
     */
    public function setStreet(string $street);

    /**
     * @return string
     */
    public function getStreetNo() : string;

    /**
     * @param string $streetNo
     */
    public function setStreetNo(string $streetNo);

    /**
     * @return string
     */
    public function getFlatNo() : string;

    /**
     * @param string $flatNo
     */
    public function setFlatNo(string $flatNo);

    /**
     * @return string
     */
    public function getPostCode() : string;

    /**
     * @param string $postCode
     */
    public function setPostCode(string $postCode);

    /**
     * @return string
     */
    public function getProvince() : string;

    /**
     * @param string $province
     */
    public function setProvince(string $province);

    /**
     * @return string
     */
    public function getCity() : string;

    /**
     * @param string $city
     */
    public function setCity(string $city);

    /**
     * @return string
     */
    public function getCountry() : string;

    /**
     * @param string $country
     */
    public function setCountry(string $country);
}
