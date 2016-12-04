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
use WellCommerce\Bundle\CoreBundle\Entity\AddressTrait;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;

/**
 * Class ContactTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTranslation implements LocaleAwareInterface
{
    use Translation;
    use AddressTrait;
    
    protected $name          = '';
    protected $email         = '';
    protected $phone         = '';
    protected $businessHours = '';
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    
    public function getPhone(): string
    {
        return $this->phone;
    }
    
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }
    
    public function getBusinessHours(): string
    {
        return $this->businessHours;
    }
    
    public function setBusinessHours(string $businessHours)
    {
        $this->businessHours = $businessHours;
    }
}
