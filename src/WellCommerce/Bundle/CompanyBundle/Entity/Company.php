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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class Company
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Company implements CompanyInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use Blameable;
    
    protected $name      = '';
    protected $shortName = '';
    protected $address;
    
    public function __construct()
    {
        $this->address = new CompanyAddress();
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getShortName(): string
    {
        return $this->shortName;
    }
    
    public function setShortName(string $shortName)
    {
        $this->shortName = $shortName;
    }
    
    public function getAddress(): CompanyAddress
    {
        return $this->address;
    }
    
    public function setAddress(CompanyAddress $address)
    {
        $this->address = $address;
    }
}
