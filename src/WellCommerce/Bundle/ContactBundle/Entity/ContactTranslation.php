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

namespace WellCommerce\Bundle\ContactBundle\Entity;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;

/**
 * Class ContactTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTranslation implements LocaleAwareInterface
{
    use Translation;

    private $name;
    private $email;
    private $phone;
    private $businessHours;
    private $line1;
    private $line2;
    private $postalCode;
    private $state;
    private $city;
    private $country;

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPhone() : string
    {
        return $this->phone;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    public function getBusinessHours() : string
    {
        return $this->businessHours;
    }

    public function setBusinessHours(string $businessHours)
    {
        $this->businessHours = $businessHours;
    }

    public function getLine1() : string
    {
        return $this->line1;
    }

    public function setLine1(string $line1)
    {
        $this->line1 = $line1;
    }

    public function getLine2() : string
    {
        return $this->line2;
    }

    public function setLine2(string $line2)
    {
        $this->line2 = $line2;
    }

    public function getPostalCode() : string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function getState() : string
    {
        return $this->state;
    }

    public function setState(string $state)
    {
        $this->state = $state;
    }

    public function getCity() : string
    {
        return $this->city;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function getCountry() : string
    {
        return $this->country;
    }

    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    public function getCopyingSensitiveProperties() : array
    {
        return [
            'name',
        ];
    }
}
