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
    public function getLine1() : string;

    public function setLine1(string $street);

    public function getLine2() : string;

    public function setLine2(string $streetNo);

    public function getPostalCode() : string;

    public function setPostalCode(string $postalCode);

    public function getState() : string;

    public function setState(string $state);

    public function getCity() : string;

    public function setCity(string $city);

    public function getCountry() : string;

    public function setCountry(string $country);
}
