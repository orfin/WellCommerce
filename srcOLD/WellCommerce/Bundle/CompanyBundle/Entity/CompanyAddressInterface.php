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
    public function getStreet();

    /**
     * @param string $street
     */
    public function setStreet($street);

    /**
     * @return string
     */
    public function getStreetNo();

    /**
     * @param string $streetNo
     */
    public function setStreetNo($streetNo);

    /**
     * @return string
     */
    public function getFlatNo();

    /**
     * @param string $flatNo
     */
    public function setFlatNo($flatNo);

    /**
     * @return string
     */
    public function getPostCode();

    /**
     * @param string $postCode
     */
    public function setPostCode($postCode);

    /**
     * @return string
     */
    public function getProvince();

    /**
     * @param string $province
     */
    public function setProvince($province);

    /**
     * @return string
     */
    public function getCity();

    /**
     * @param string $city
     */
    public function setCity($city);

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @param string $country
     */
    public function setCountry($country);
}
